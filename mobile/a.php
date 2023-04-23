<!DOCTYPE html>
<html>
<head>
    <title>Mask, Layer popup</title>
    <style>
        .setDiv {
            padding-top: 100px;
            text-align: center;
        }
        .mask {
            position:absolute;
            left:0;
            top:0;
            z-index:9999;
            background-color:#000;
            display:none;
        }
        .window {
            display: none;
            background-color: #ffffff;
            height: 200px;
            z-index:99999;
        }
    </style>
</head>
<body>
<div class="setDiv">
    <a href="#" class="showMask">���� ����ũ�� ���̾� �˾� ����</a>
 
    <div class="mask"></div>
    <div class="window">
        <input type="button" href="#" class="close" value="��� ������� ���̾� �˾� �Դϴ�. (�ݱ�)"/>
    </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">
    function wrapWindowByMask(){
        // ȭ���� ���̿� �ʺ� ������ ����ϴ�.
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
 
        // ����ũ�� ���̿� �ʺ� ȭ���� ���̿� �ʺ� ������ �����մϴ�.
        $('.mask').css({'width':maskWidth,'height':maskHeight});
 
        // fade �ִϸ��̼� : 1�� ���� �˰� �ƴٰ� 80%�� ���������� ���մϴ�.
        $('.mask').fadeIn(1000);
        $('.mask').fadeTo("slow",0.8);
 
        // ���̾� �˾��� ����� ���� ���� ȭ���� ���̿� �ʺ��� ��� ���� ��ũ�� ���� ���Ͽ� ������ ����ϴ�.
        var left = ( $(window).scrollLeft() + ( $(window).width() - $('.window').width()) / 2 );
        var top = ( $(window).scrollTop() + ( $(window).height() - $('.window').height()) / 2 );
 
        // css ��Ÿ���� �����մϴ�.
        $('.window').css({'left':left,'top':top, 'position':'absolute'});
 
        // ���̾� �˾��� ���ϴ�.
        $('.window').show();
    }
 
    $(document).ready(function(){
        // showMask�� Ŭ���� �۵��ϸ� ���� ����ũ ���� ���̾� �˾��� ���ϴ�.
        $('.showMask').click(function(e){
            // preventDefault�� href�� ��ũ �⺻ �ൿ�� ���� ����Դϴ�.
            e.preventDefault();
            wrapWindowByMask();
        });
 
        // �ݱ�(close)�� ������ �� �۵��մϴ�.
        $('.window .close').click(function (e) {
            e.preventDefault();
            $('.mask, .window').hide();
        });
 
        // �� ���� ����ũ�� Ŭ���ÿ��� ��� �����ϵ��� ó���մϴ�.
        $('.mask').click(function () {
            $(this).hide();
            $('.window').hide();
        });
    });
</script>
</html>
