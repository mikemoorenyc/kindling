jQuery(document).ready(function( $ ) {
$(window).load(function(){
     $('#post-formats-select input:radio[name="post_format"]').each(function(){
         if($(this).attr('checked') == 'checked') {
          postType = $(this).attr('value');
         }
     });
    console.log(postType);
    if (postType == 'link') {
        formEval();
        $("#postdivrich").addClass('deactivated');
    } else {
        $("#post-attachment").addClass('deactivated');
    }


   console.log('connected with jquery');
   $('#post-formats-select input:radio[name="post_format"]').change(function(){
      postType = $(this).val();
      if($(this).val() == 'link') {
          linkSwapper('link');

      } else {
          linkSwapper('post');
      }
   });

   setInterval(function(){
      formEval();
   },1000)



   function linkSwapper(state) {
        if(state=='post') {
            $("#post-attachment").addClass('deactivated');
            $("#postdivrich").removeClass('deactivated');
            $('#publishing-action input').removeAttr('disabled');
        }
        if(state == 'link') {
           $("#post-attachment").removeClass('deactivated');
            $("#postdivrich").addClass('deactivated');
            formEval();
        }
    }

    function formEval() {
        $attachment = $('#post-attachment input#attachmentfile').attr('value');
        $type = $('#post-attachment input#file-type').attr('value');
        //console.log($type);
        //console.log($attachment);
        if(postType == 'link') {
           if($type =='' || $attachment == '') {
                $('#publishing-action input').attr('disabled','');
            } else {
                $('#publishing-action input').removeAttr('disabled');
            }
        }

    }
});



});
