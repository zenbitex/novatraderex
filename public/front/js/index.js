/**
 * Created by Administrator on 2017/10/12 0012.
 */
$(function () {
    // 菜单
    $(".nav .btns").click(function (event) {
        event.stopPropagation();
        $(this).siblings().children('.chil').hide()
        $(this).children('.chil').slideToggle();
    })
   // 下拉bit
    $(".doww>span").click(function () {
        $(this).parents('li').siblings().find('ul').hide()
        $(this).children('ul').slideToggle(200);
    })
    $(document).click(function() {
        $(".nav .btns").children('.chil').slideUp(200)
        $(".doww>span").parents('li').find('ul').slideUp(200)
    })
})


// 适用移动端
$(function () {
    //判断屏幕宽度(判断是PC还是移动端)
    var count=$(document).width();

    //点击显示移动端导航栏
    $('#hearter-phone .leftbtn>a').click(function () {
        var src=$(this).children('img').attr('src');
        if(src==='images/common/left-btn2.png'){
            $(this).children('img').css("height","17");
            $('#hearter-phone .listphon').slideUp(200);
            src=$(this).children('img').attr('src').replace('left-btn2.png','left-btn.png');
        }else {
            $(this).children('img').css("height","22");
            $('#hearter-phone .listphon').slideDown(200);
            src=$(this).children('img').attr('src').replace('left-btn.png','left-btn2.png');
        }
        $(this).children('img').attr('src',src);

    })
    //点击显示移动端导航栏结束！
    //鼠标点击改变导航条样式
    $('#hearter-phone .listphon ul>li').click(function () {
        $(this).addClass('activer').siblings().removeClass('activer');
    });
    //移动端二级动画开始
    $("#hearter-phone .listphon .down_1").click(function(){
        if($(this).siblings().css("display") == "none"){
            $(this).siblings().slideDown();
            $(this).addClass("animate");
        }else{
            $(this).siblings().slideUp();
            $(this).removeClass("animate");
        }
    })
    //移动端二级动画结束

    //点击按钮回到顶部
    $(window).scroll(function () {
        if(count<960){
            if($(this).scrollTop()>=700){
                $('#backtop').css('display','block').click(function () {
                    $(window).scrollTop(0);
                });
            }
            else {
                $('#backtop').css('display','none');
            }

        }

    })
    //点击按钮回到顶部结束
})
// 适用移动端结束
