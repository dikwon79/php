<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API</title>
     <script>
        function regist() {
            $.ajax({
              url: 'api/v1/users',
              contentType: 'application/json',
              method: 'POST',
              data: JSON.stringify({
                  userid: $('#userid').val(),
                  username: $('#username').val(),
                  password: $('#password').val(),
                  're-password': $('#re-password').val()
              })
            }).done(function (res) {
                alert('회원가입에 성공햇습니다.');
                window.location = '/';
            });
        }
    </script>

</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <h1>센터정보</h1>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <form method="POST" action="/api/v1/users">
                    <div class="form-group">
                
                        <label for="companyname">납품센터</label>
                        <input type="text" class="form-control" id="companyname" placeholder="cj,spc,shinsegye" name="companyname" />
                    </div>
                    <div class="form-group">
                       
                        <label for="center">센터코드</label>
                        <input type="text" class="form-control" id="center" placeholder="센터코드" name="center" />
                    </div>
                    <div class="form-group">
                       
                        <label for="centername">센터명</label>
                        <input type="text" class="form-control" id="centername" placeholder="센터명" name="centername" />
                    </div>
                    <div class="form-group">
                       
                        <label for="grouping">그룹제어명</label>
                        <input type="text" class="form-control" id="grouping" placeholder="그룹제어명" name="grouping" />
                    </div>
					<div class="form-group">
                       
                        <label for="printinfo">인쇄물명</label>
                        <input type="text" class="form-control" id="printinfo" placeholder="인쇄물명" name="printinfo" />
                    </div>
                    <button type="button" class="btn btn-primary" onclick='regist();'>등록</button>
                </form>
            </div>
        </div>
    </div>


    
</body>
</html>