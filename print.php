<HTML>
<HEAD>
<TITLE>happyscript.com</TITLE>
</HEAD>

<script language="javascript">
// http://happyscript.com
function printWindow() {
factory.printing.header = "머릿글로 출력되는 부분입니다."
factory.printing.footer = "바닥글로 출력되는 부분입니다."
factory.printing.portrait = true
factory.printing.leftMargin = 30.0
factory.printing.topMargin = 30.0
factory.printing.rightMargin = 30.0
factory.printing.bottomMargin = 30.0
factory.printing.Print(false, window)
}
</script>

<BODY>
<object id=factory style="display:none" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="http://www.meadroid.com/scriptx/ScriptX.cab#Version=6,1,429,14">
</object>
<p>
프린팅 테스트
</p>
<p>
웹페이지의 프린트 제어 <br>
http://happyscript.com
</p>
<input type="button" name="print" value="Print This Page..." onClick="printWindow();">
</BODY>
</HTML>
[출처] 웹페이지 인쇄하는 소스|작성자 콩이