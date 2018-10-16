$(function() {

    /*gogle-input*/
    $(".gg-input").on('keyup',function() {
        if($(this).next('input').length == 0) {
            $(this).blur()
            return;
        }
        $(this).next('input').focus()
    })

    $(".set_btn").on('click',function(){
        if($(this).parent().is('.authy')) {
            $(this).parent().next().slideToggle()
        }else{
            $('.authy').find('.mask').fadeToggle()
        }
        if($(this).parent().is('.sms')) {
            $(this).parent().next().slideToggle()
        }else{
            $('.sms').find('.mask').fadeToggle()
        }
        if($(this).parent().is('.google')) {
            $(this).parent().next().slideToggle()
        }else{
            $('.google').find('.mask').fadeToggle()
        }
    })
})