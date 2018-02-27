String.prototype.ucfirst = function() {
   return this.charAt(0).toUpperCase() + this.slice(1);
}

String.prototype.ucwords = function() {
    let words = this.split(' ');
    let string = '';
    words.map(function(word) {
        string += word.ucfirst();
        string += ' ';
    });
    return string.trim();
}

function fixChoosen() {
    var els = jQuery("#element-values-data-type");
    els.on("chosen:showing_dropdown", function () {
       $(this).parents("div").css("overflow", "visible");
    });
    els.on("chosen:hiding_dropdown", function () {
       var $parent = $(this).parents("div");
 
       // See if we need to reset the overflow or not.
       var noOtherExpanded = $('.chosen-with-drop', $parent).length == 0;
       if (noOtherExpanded)
          $parent.css("overflow", "auto");
        //   $parent.css("height", "55px");
    });
 }