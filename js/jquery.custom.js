/*-----------------------------------------------------------------------------------

 	Custom JS - All front-end jQuery
 
-----------------------------------------------------------------------------------*/
	
$(function(id) {

  // Preloader
  $(window).load(function(){
	  $('#preloader').fadeOut(500,function(){$(this).remove();});
  });
  
  // Tooltip
  $('.trigger').tooltip({
	  relative: true, 
	  position: 'bottom right', 
	  effect: 'slide', 
	  offset: [15, -180], 
	  delay: 500 
  });

  // Loading Message
  $('#submit').click(function(){		
	  $('#loading').slideDown(500);
	  $('body,html').animate({scrollTop:0},800);
  });
  
  // Alert Messages
  setTimeout(function() {
	  $("#success, #error").slideUp(500);
  }, 10000);
  
  // Banner animation
  var offset = $(".banner").offset();
  var topPadding = 20;
  $(window).scroll(function() {
	  if ($(window).scrollTop() > offset.top) {
		  $(".banner").stop().animate({
			  marginTop: $(window).scrollTop() - offset.top + topPadding
		  });
	  } else {
		  $(".banner").stop().animate({
			  marginTop: 0
		  });
	  };
  });

  // Main Functions
  var count_dropped_hits = 0;
  var data = { "images" : [{ "id" : "object0" }] };
  
  // Array Remove - By John Resig (MIT Licensed)
  Array.prototype.remove = function(from, to) {
	  var rest = this.slice((to || from) + 1 || this.length);
	  this.length = from < 0 ? this.length + from : from;
	  return this.push.apply(this, rest);
  };
			  
  // Remove an object from data 
  $('.remove',$('#tools')).live('click',function(){
	  var $this = $(this);
				  
	  // The element next to this is the input that stores the obj id
	  var objid = $this.next().val();
	  // Remove the object from the sidebar 
	  $this.parent().remove();
	  // ,from the picture 
	  var divwrapper = $('#'+objid).parent().parent();
	  $('#'+objid).remove();
	  
	  // Add again to the elements list 
	  var image_elem = $this.parent().find('img');
	  var thumb_width = image_elem.attr('width');
	  var thumb_height = image_elem.attr('height');
	  var thumb_src = image_elem.attr('src');
	  $('<img/>',{
		  id : objid,
		  src : thumb_src,
		  width : thumb_width, 
		  height : thumb_height,
		  addClass : 'ui-widget-content'
	  }).appendTo(divwrapper).resizable({
		  handles : 'se',
		  stop : resizestop 
	  }).parent('.ui-wrapper').draggable({
		  revert: 'invalid'
	  });

	  // And unregister it - delete from object data 
	  var index = exist_object(objid);
	  data.images.remove(index);
  });
			  
  // Checks if an object was already registered 
  function exist_object(id){
	  for(var i = 0;i<data.images.length;++i){
		  if(data.images[i].id == id)
		  return i;
	  }
	  return -1;
  }
			  
  // Triggered when stop resizing an object
  function resizestop(event, ui) {
	  // Calculate and change values to obj (width and height)
	  var $this = $(this);
	  var objid = $this.find('.ui-widget-content').attr('id');
	  var objwidth = ui.size.width;
	  var objheight = ui.size.height;
	  var index = exist_object(objid);
			  
	  if(index!=-1) { //if exists (it should!) update width and height
		  data.images[index].width = objwidth;
		  data.images[index].height = objheight;
	  }
  }
  
  // Elements are resizable and draggable 
  $('#elements img').resizable({
	  // Only diagonal (south east)
	  handles : 'se',
	  stop : resizestop 
  }).parent('.ui-wrapper').draggable({
	  revert : 'invalid'
  });
			  
  $('#background').droppable({
	  accept : '#elements div', // Accept only draggables from #elements 
	  drop : function(event, ui) {
		  var $this = $(this);
		  ++count_dropped_hits;
		  var draggable_elem = ui.draggable;
		  draggable_elem.css('z-index',count_dropped_hits);
		  
		  // Object was dropped : register it 
		  var objsrc = draggable_elem.find('.ui-widget-content').attr('src');
		  var objwidth = parseFloat(draggable_elem.css('width'),10);
		  var objheight = parseFloat(draggable_elem.css('height'),10);
				  
		  // For top and left we decrease the top and left of the droppable element 
		  var objtop = ui.offset.top - $this.offset().top;
		  var objleft = ui.offset.left - $this.offset().left;                     
		  var objid = draggable_elem.find('.ui-widget-content').attr('id');
		  var index = exist_object(objid);
		  
		  if(index!=-1) { // If exists update top and left
			  data.images[index].top = objtop;
			  data.images[index].left = objleft;
		  }
		  else{					
			  // Register new one
			  var newObject = { 
				  'id' : objid,
				  'src' : objsrc,
				  'width' : objwidth,
				  'height' : objheight,
				  'top' : objtop,
				  'left' : objleft,
				  'rotation' : '0'
			  };
			  data.images.push(newObject);
			  // Add object to sidebar
						  
			  $('<div/>',{
				  addClass : 'item'
			  }).append(
				  $('<div/>',{
					  addClass : 'thumb',
					  html : '<img width="43" height="'+objheight+'" class="ui-widget-content" src="'+objsrc+'"/>'
				  })
			  ).append(
				  $('<div/>',{
					  addClass : 'slider',
					  id : objid+'slider',
					  html : '<span>Rotate</span><span class="degrees">0</span>'
				  })
			  ).append(
				  $('<a/>',{
					  addClass : 'remove'
				  })
			  ).append(
				  $('<input/>',{
					  type : 'hidden',
					  value : objid // Keeps track of which object is associated
				  })
			  ).appendTo($('#tools')); 
			  $('#'+objid+'slider').slider({
				  orientation	: 'horizontal',
				  max : 180,
				  min : -180,
				  value : 0,
				  slide : function(event, ui) {
					  var $this = $(this);
					  // Change the rotation and register that value in data object when it stops
					  draggable_elem.rotate({angle:ui.value});
					  $('.degrees',$this).html(ui.value);
				  },
				  stop : function(event, ui) {
					  newObject.rotation = ui.value;
				  }
			  });	 
		  }
	  }
  });
		  
  // User presses the upload button 
  $('#submit').bind('click',function(){
	  var dataString = JSON.stringify(data);
	  $('#jsondata').val(dataString);
	  $('#jsonform').submit();
  });

});