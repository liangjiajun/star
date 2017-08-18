    $(function() {
    var imger_size = 2;
    var newspan_state = 'area';
    function scrollfun(){
        $('body').bind('mousewheel', function(event, delta) {
            ;
            removeClass_fun();
            var dir = delta > 0 ? 'Up' : 'Down';
            if(dir=='Down'){
                imger_size--;
                if(imger_size==2){
                    $('#map').css('left',$('#map').width()-$(window).width()+'px')
                                .css('top',$('#map').height()-$(window).height()-70+'px');
                }
                if(imger_size<=1){
                    imger_size=1;
                    $('#map').css('left','0px').css('top','0px');

                }
                $('#map').css('transform','scale('+imger_size+')')
                $('#range').val(4-imger_size);

            }
            
            if(dir=='Up'){
                imger_size++;
                if(imger_size==2){
                    $('#map').css('left',$('#map').width()-$(window).width()+'px')
                                .css('top',$('#map').height()-$(window).height()-70+'px');
                }
                if(imger_size>=3){
                    imger_size=3;
                }
                drag_fun();
                $('#range').val(4-imger_size);
                $('#map').css('transform','scale('+imger_size+')');
            }
            return false;
        });
    }
    scrollfun();
    $('#range').on('input',function(){
        $('#map').css('transform','scale('+(4-$(this).val())+')');
        imger_size = 4-$(this).val();
        if(imger_size==2){
            $('#map').css('left',$('#map').width()-$(window).width()+'px')
                       .css('top',$('#map').height()-$(window).height()-70+'px');
                }
        if(imger_size==1){
            $('#map').css('left','0px').css('top','0px');
        }

    });
});