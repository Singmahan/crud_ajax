<h1>เพิ่มข้อมูล</h1>

<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">ชื่อ - นามสกุล</label>
  <input type="text" class="form-control" id="uname" placeholder="ชื่อ - นามสกุล">
</div>

<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">เบอร์โทร</label>
  <input type="tel" class="form-control" id="tel" placeholder="เบอร์โทร">
</div>

<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Email Address</label>
  <input type="email" class="form-control" id="email" placeholder="Email Address">
</div>

<button type="button" class="btn btn-success insert_data">เพิ่มข้อมูล</button>

<script>
  // insert data 
  $(document).on('click', '.insert_data', function() {
    var uname = document.getElementById("uname").value;
    var tel = document.getElementById("tel").value;
    var email = document.getElementById("email").value;

    if (uname == "") {
      document.getElementById("uname").focus();

    } else if (tel == "") {
      document.getElementById("tel").focus();

    } else if (email == "") {
      document.getElementById("email").focus();
    } else {
      $.ajax({
        url: "app.php",
        method: "POST",
        data: {
          program: "insert_data",
          uname: uname,
          tel: tel,
          email: email
        },
        success: function(msg) {
          if (msg == 'ok') {
            Swal.fire(
              'เพิ่มรายการสำเร็จ!',
              '',
              'success'
            ).then(function() {
              window.location.href = "?pt=list_data";
            })
          } else {
            Swal.fire(
              'เกิดข้อผิดพลาด!',
              'โปรดลองใหม่อีกครั้ง',
              'error'
            )
          }
        }
      });
    }

  });
</script>