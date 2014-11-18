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
