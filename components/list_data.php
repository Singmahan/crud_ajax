<?php

$sql = "SELECT
    `student_codeid`,
    `student_name`,
    `student_tel`,
    `student_email`
FROM
    `student`";

$query_sql = $connectdb->query($sql);

?>
<div class="alert alert-primary" role="alert">
  สวัสดีคุณ <?php echo $_SESSION['login_name'];  ?>
</div>
<h1>แสดงผลข้อมูล</h1>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ลำดับ</th>
            <th scope="col">ชื่อ - นามสกุล</th>
            <th scope="col">เบอร์โทร</th>
            <th scope="col">อีเมล</th>
            <th scope="col">จัดการ</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $count = 0;
        while ($res = mysqli_fetch_array($query_sql)) { ?>
            <tr>
                <th scope="row"><?php echo $count = $count + 1; ?></th>
                <td><?php echo $res['student_name']; ?></td>
                <td><?php echo $res['student_tel']; ?></td>
                <td><?php echo $res['student_email']; ?></td>
                <td>
                    <button type="button" class="btn btn-primary edit_data" id="<?php echo $res['student_codeid']; ?>">แก้ไข</button>
                    <button type="button" class="btn btn-danger delete_data" id="<?php echo $res['student_codeid']; ?>">ลบ</button>
                </td>
            </tr>
        <?php } ?>

        <!-- Modal Edit Data-->
        <div class="modal fade" id="modal_edit_data">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูล</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
                        <button type="button" class="btn btn-primary save_edit_data">อัพเดท</button>
                    </div>

                    <input type="hidden" id="id_data">
                </div>
            </div>
        </div>

        <script>
            // Update data
            $(document).on('click', '.save_edit_data', function() {
                id_data = document.getElementById("id_data").value;
                uname = document.getElementById("uname").value;
                tel = document.getElementById("tel").value;
                email = document.getElementById("email").value;
                $.ajax({
                    url: "app.php",
                    method: "POST",
                    data: {
                        id_data: id_data,
                        program: "save_edit_data",uname:uname, tel:tel, email:email
                    },
                    success: function(msg) {
                        if (msg == 'ok') {
                            Swal.fire(
                                'แก้ไขข้อมูลสำเร็จ!',
                                '',
                                'success'
                            ).then(function() {
                                window.location.reload();
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

            });

            // edit data 
            $(document).on('click', '.edit_data', function() {
                id = $(this).attr("id");
                $.ajax({
                    url: "app.php",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        encodeid: id,
                        program: "edit_data"
                    },
                    success: function(msg) {
                        student_name = msg[0]['student_name'];
                        student_tel = msg[0]['student_tel'];
                        student_email = msg[0]['student_email'];

                        document.getElementById("uname").value = student_name;
                        document.getElementById("tel").value = student_tel;
                        document.getElementById("email").value = student_email;
                        document.getElementById("id_data").value = id;
                        $("#modal_edit_data").modal('show');
                    }
                });

            });

            // delete data เวลาทำ ทำ delete ก่อนนะ
            $(document).on('click', '.delete_data', function() {
                id = $(this).attr("id");
                Swal.fire({
                    title: 'ยืนยันการลบรายชื่อนี้ใช่หรือไม่ ?',
                    text: "ลบรายชื่อนี้จะไม่สามารถกู้คืนได้อีก",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยันการลบรายการ',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "app.php",
                            method: "POST",
                            data: {
                                id: id,
                                program: "delete_data"
                            },
                            success: function(msg) {
                                if (msg == 'ok') {
                                    Swal.fire(
                                        'ลบรายการสำเร็จ!',
                                        '',
                                        'success'
                                    ).then(function() {
                                        window.location.reload();
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
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire(
                            'ยกเลิกรายการได้รับการยกเลิก',
                            '',
                            'error'
                        )
                    }
                })
                return false;
            });
        </script>
    </tbody>
</table>