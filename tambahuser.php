<link rel="stylesheet" href="./style/input.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
            <i class="fa-solid fa-clipboard-list"></i> Tambah User
        </div>

        <!-- Form untuk menambah item -->
        <div class="form-container" style="background-color: #76453B; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 50px;">Tambah User Baru</h3>
            <form id="addItemForm" >
                
                <input  type="text"  required placeholder="Username">

                <input type="text" required placeholder="Email">

                <input type="text" required placeholder="Password">


                <button type="submit" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B; margin-bottom: 10px;">Tambah Item</button>
                <a href="index.php?page=users" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B;">Kembali</a>
            </form>
        </div>


    </div>
</div>
