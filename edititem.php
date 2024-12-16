<link rel="stylesheet" href="./style/input.css">
<div class="col-md-9 content" style="margin-left: 400px;">
    <div class="row">
        <div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
            <i class="fa-solid fa-clipboard-list"></i> Edit Item
        </div>

        <!-- Form untuk menambah item -->
        <div class="form-container" style="background-color: #76453B; padding: 20px; border-radius: 10px;">
            <h3 style="margin-bottom: 50px;">Edit Item </h3>
            <form id="addItemForm" >
                
                <input  type="text" id="itemName" required placeholder="Nama Barang">

                <input type="text" id="itemCategory" required placeholder="Kategori Barang">

                <input type="number" id="itemStock" required placeholder="Stok Barang">

                <input type="number" id="itemPrice" required placeholder="Harga">

                <button type="submit" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B; margin-bottom: 10px;">Simpan</button>
                <a href="index.php?page=stok" class="btn btn-primary" style="background-color: #DCD7C9; color: #76453B;">Kembali</a>
            </form>
        </div>


    </div>
</div>
