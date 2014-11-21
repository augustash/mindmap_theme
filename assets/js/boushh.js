(function ($, Drupal) {

	Drupal.behaviors.selectReplace = {
	    attach: function(context, settings) {
	    	jQuery("select").selectbox();
	    }
	};

	Drupal.behaviors.boushh = {
	attach: function(context, settings) {
	  
		if (window.addEventListener) {
	      window.addEventListener("load", function() {
	        var scripts = document.getElementsByTagName("script");
	        var canvasArray = Array.prototype.slice.call(document.getElementsByTagName("canvas"));
	        var canvas;
	        for (var i = 0, j = 0; i < scripts.length; i++) {
	          if (scripts[i].type == "application/processing") {
	            var src = scripts[i].getAttribute("target");
	            if (src && src.indexOf("#") > -1) {
	              canvas = document.getElementById(src.substr(src.indexOf("#") + 1));
	              if (canvas) {
	                new Processing(canvas, scripts[i].text);
	                for (var k = 0; k< canvasArray.length; k++)
	                {
	                  if (canvasArray[k] === canvas) {
	                    // remove the canvas from the array so we dont override it in the else
	                    canvasArray.splice(k,1);
	                  }
	                }
	              }
	            } else {    
	              if (canvasArray.length >= j) {
	                new Processing(canvasArray[j], scripts[i].text);          
	              }
	              j++;
	            }       
	          }
	        }
	      }, false);
	    }
	  
	  }
	};

	Drupal.behaviors.stickySide = {
    	attach: function (context, settings) {

     		$('.page-header').waypoint('sticky', {
        		offset: 45
      		});
      
     	}
    };

    Drupal.behaviors.searchPlaceholder = {
    	attach: function (context, settings) {
		    $('#views-exposed-form-mindmap-elements-block-1 #edit-title').attr("placeholder","Search by title");
      		$('#views-exposed-form-mindmap-elements-block-7 #edit-title').attr("placeholder","Search by title");
     		$('#views-exposed-form-mindmap-elements-block-2 #edit-combine').attr("placeholder","Search by title or Name");
     		$('#views-exposed-form-mindmap-elements-block-9 #edit-title').attr("placeholder","Search by title");
      		$('#views-exposed-form-mindmap-elements-block-10 #edit-title').attr("placeholder","Search by title");
     		$('#views-exposed-form-mindmap-elements-block-11 #edit-combine').attr("placeholder","Search by title or Name");
     	}
    };

    Drupal.behaviors.anyOptions = {
    	attach: function (context, settings) {
			$('#views-exposed-form-mindmap-elements-block-1 .sbSelector').text('By Category');
			$('#views-exposed-form-mindmap-elements-block-7 .sbSelector').text('By Category');
			$('#views-exposed-form-mindmap-elements-block-2 .sbSelector').text('By Category');
			$('#views-exposed-form-mindmap-elements-block-9 .sbSelector').text('By Category');
			$('#views-exposed-form-mindmap-elements-block-10 .sbSelector').text('By Category');
			$('#views-exposed-form-mindmap-elements-block-11 .sbSelector').text('By Category');
		}
    };

    Drupal.behaviors.colorSample = {
    	attach: function (context, settings) {
     		
     		// category view sample
     		$('.views-field-title .icon').each(function() {
     			var colorcode = $(this).find('.color > div').css('backgroundColor');

     			$(this).wrap('<div class="icon" style="background-color:' + colorcode + '" />');

     			$(this).find('.color').detach();

     		});

     		// dashboard table groupings
     		$('.view-mindmap-elements caption').each(function() {
     			var colorcode = $(this).find('div').css('backgroundColor');

     			$(this).css('background-color', colorcode);

     			$(this).find('div').detach();

     		});

     		// category picker wrap
     		$('#edit-field-category-und .form-item').each(function() {
     		 	var colorcode = $(this).find('.color').text();

     		 	$(this).wrap('<div class="icon" style="background-color:' + colorcode + '" />');

     		 	$(this).find('.color').detach();

     		});

     		// give current category active class
			$('#edit-field-category-und').find('input:checked').parents('.icon').addClass('active');

			// swap active classes on click
			$('#edit-field-category-und label').click(function() {
				$('#edit-field-category-und .icon').removeClass('active');
				$(this).parents('.icon').addClass('active');
			});   
						
     	}
    };

    // this is useless until we can stop tab trimming
    Drupal.behaviors.viewsTabs = {
    	attach: function (context, settings) {
			$('#views-display-menu-tabs > li').each(function() {
				var title = $(this).text();
				$(this).attr('title', title);
			});
		}
    };

    Drupal.behaviors.formElements = {
    attach: function(context, settings) {
    	$('input[type="checkbox"]').wrap('<div class="checkbox-wrap" />');
    	$('input[type="checkbox"]').before('<span class="psuedo-box" />');
    	$('input[type="checkbox"]').after('<i class="fa fa-check checkbox-check"></i>');

    	$('input.vbo-table-select-all').click(function() {
    		$(this).parents('table').find('input.vbo-select').each(function() {
    			$(this).parent().find('.checkbox-check').toggleClass('active');
    		});
    	});
  	}
  };

  // Drupal.behaviors.formElements = {
  //   attach: function(context, settings) {
  //   	$('input.form-checkbox').before('<i class="fa fa-square-o cust-checkbox"></i>');
  //   	$('input.form-checkbox').click(function() {
  //   		$(this).parent().find('.cust-checkbox').toggleClass('fa-check-square-o').toggleClass('fa-square-o');
  //   	});
  //   	$('input.vbo-table-select-all').click(function() {
  //   		$(this).parents('table').find('td.views-field-views-bulk-operations').find('.cust-checkbox').toggleClass('fa-check-square-o').toggleClass('fa-square-o');
  //   	});
  // 	}
  // };

})(jQuery, Drupal);
