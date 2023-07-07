</body>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script defer src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="../assets/js/table2excel.js"></script>


<!-- Local script files -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap5.bundle.min.js"></script>
<script src="../assets/js/scripts.js"></script>

<?php if (isset($_SESSION['auth_user'])) : ?>

    <footer style=" overflow-x: hidden; background-image: url('images/bg2.png');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
        " class="py-2 bg-white mt-auto fixed-bottom">
        <div class="container-fluid px-2">
            <div class="d-flex align-items-center justify-content-between small">
                <div style="color:white;" class=" align-items-center text"><?= $_SESSION['auth_user']['fullname'];  ?> &copy; <?= $_SESSION['auth_user']['email'];  ?></div>
                <div>

                </div>
            </div>
        </div>
    </footer>



<?php else : ?>

    <footer style=" overflow-x: hidden; background-image: url('images/bg2.png');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
        " class="py-2 bg-white mt-auto fixed-bottom">
        <div class="container-fluid px-2">
            <div class="d-flex align-items-center justify-content-between small">
                <div style="color:white;" class="text">Ali Can Doğan &copy; 180343</div>
                <div>
                    <a style="color:white;" href="https://github.com/doganalican46" target="_blank">Git&Hub</a>
                    &middot;
                    <a style="color:white;" href="#" target="_blank">BitBucket</a>
                    &middot;
                    <a style="color:white;" href="https://www.linkedin.com/in/doganalican46/" target="_blank">LinkedIn</a>
                </div>
            </div>
        </div>
    </footer>

<?php endif; ?>







</html>