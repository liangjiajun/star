/**
 * Created by GUI on 2016/12/29.
 */
$(function(){

    var audio = document.getElementById("bgMusic");
    audio.play();
    $('.round').click(function(){
        if($('.status').hasClass("play")){
            $('.status').removeClass("play").addClass("pause");
            audio.play();
        }else{
            $('.status').removeClass("pause").addClass("play");
            audio.pause();
        }
    })






})