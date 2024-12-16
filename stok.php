<link rel="stylesheet" href="./style/table.css">
<div class="col-md-9 content" style="margin-left: 400px;" >
<div class="row">
<div class="contr">
<div style="color:#DCD7C9; font-size: 40px; margin-bottom: 40px;">
    <i class="fa-solid fa-clipboard-list"></i> Manajemen Stok Barang
</div>
    <div class="hdr">
        <div class="title">
                <i class="fas fa-plus-circle" style="color: #DCD7C9;"></i>
                <button class="btn-add" ><a style="text-decoration: none; color: #DCD7C9;" href="index.php?page=tambahitem">ADD ITEM</a></button>
            </div>
        <div class="search">
            <div style="position: relative;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: -2px; top: 50%; transform: translateY(-50%); color: #76453B; "></i>
                <input type="text" placeholder="Type to Search" class="inpt" style="padding-left: 40px; border-radius: 50px;">
            </div>
                <i class="fas fa-sort" style="margin:10px;"></i> Sort
                <i class="fas fa-filter" style="margin:10px;"></i> Filter
        </div>
    </div>
        <table id="dataContainer">
            <thead style="color: #D5CEC0; ">
  
                <tr >
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kategori Barang</th>
                    <th>Stok Barang</th>
                    <th>Harga Barang</th>
                    <th>Action Button</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Sabun</td>
                    <td>Elektronik</td>
                    <td>70</td>
                    <td>100.000</td>
                    <td class="action-buttons" >
                        <a class="edit-btn" href="index.php?page=edititem" style="text-decoration: none;">EDIT</a>
                        <a class="delete-btn" href="index.php?page=hapusitem" style="text-decoration: none;">DELETE</a>
                    </td>
                </tr>
                
            </tbody>
        </table>
<div class="footer d-flex justify-content-center align-items-center" style="color: #DCD7C9;">
    <div>
        Rows per page:
        <select id="rowsPerPage" onchange="updateTable()" style="background-color: #76453B; color: #DCD7C9;">
            <option value="8">8</option>
            <option value="16">16</option>
            <option value="32">32</option>
        </select>
    </div>
    <div class="pagination" style="margin-left: 20px;">
        <span id="pageInfo">1-8 of 1240</span>
        <i class="fas fa-chevron-left" onclick="previousPage()"></i>
        <i class="fas fa-chevron-right" onclick="nextPage()"></i>
    </div>
</div>


    </div>
  </div>
</div>