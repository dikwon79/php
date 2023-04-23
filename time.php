<script>
var first = new Date();
first.setHours(0, 0, 0);

var second = new Date();
second.setHours(1, 0, 0);

alert("Diff in seconds: " + (second - first)/3600/1000);//300000

</script>