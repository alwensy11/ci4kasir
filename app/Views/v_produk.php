<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.0.2-dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free-6.6.0-web/css/all.min.css') ?>">
    <script src="<?= base_url('assets/jquery-3.7.1.min.js') ?>"></script>   
    <title>Produk</title>
</head>
<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <h3 class="text-center">Data Produk</h3>
                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalTambahProduk"><i class="fa-solid fa-cart-plus"></i> Tambah Data</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="container mt-5">
                <table class="table table-bordered" id="produkTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimasukkan melalui AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalLabelTambah">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalLabelTambah">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3 row">
                            <label for="produkNama" class="col-sm-3 col-form-label">Nama Produk</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="namaProduk" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="harga" class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="hargaProduk" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="stok" class="col-sm-3 col-form-label">Stok</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="stokProduk" required>
                            </div>
                        </div>
                        <button type="button" id="simpanProduk" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Tambah Produk -->

    <!-- Modal Edit Produk -->
    <div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="modalLabelEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalLabelEdit">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditProduk">
                        <input type="hidden" id="editProdukId">
                        <div class="mb-3 row">
                            <label for="editNamaProduk" class="col-sm-3 col-form-label">Nama Produk</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="editNamaProduk" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="editHarga" class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="editHarga" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="editStok" class="col-sm-3 col-form-label">Stok</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="editStok" required>
                            </div>
                        </div>
                        <button type="button" id="updateProduk" class="btn btn-primary float-end">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Edit Produk -->

    <script>
        $(document).ready(function(){
            function tampilProduk() {
                $.ajax({
                    url: '<?= base_url('produk/tampil')?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil.status == 'success') {
                            var produkTable = $('#produkTable tbody');
                            produkTable.empty(); //Hapus semua isi table

                            var produk = hasil.produk;
                            var no = 1;

                            // Looping untuk memasukkan data ke dalam table
                            produk.forEach(function(item) {
                                var row = '<tr>' +
                                    '<td>' + no + '</td>' +
                                    '<td>' + item.nama_produk + '</td>' +
                                    '<td>' + item.harga + '</td>' +
                                    '<td>' + item.stok + '</td>' +
                                    '<td>' +
                                        '<button class="btn btn-warning btn-sm editProduk" data-bs-toggle="modal" data-bs-target="#modalEditProduk" data-id="' + item.produk_id + '"><i class="fa-solid fa-pencil"></i> Edit</button>' +
                                        '  <button class="btn btn-danger btn-sm hapusProduk" id="hapusProduk" data-id="' + item.produk_id + '"><i class="fa-solid fa-trash-can"></i> Hapus</button>' +
                                    '</td>' +
                                '</tr>';
                                produkTable.append(row);
                                no++;
                            });
                        } else {
                            alert('Gagal mengambil data.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: '+ error);
                    }
                });
            }

            tampilProduk();

            
            $("#simpanProduk").on("click", function(){
                var formData = {
                    nama_produk : $("#namaProduk").val(),
                    harga : $("#hargaProduk").val(),
                    stok : $("#stokProduk").val(),
                };

                $.ajax({
                    url: '<?= base_url('produk/simpan')?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil.status =='success') {
                            // alert(hasil.message);
                            $("#modalTambahProduk").modal("hide");
                            tampilProduk();
                        } else {
                            alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: '+ error);
                    }
                });
            });


            // Fungsi untuk menampilkan data produk di modal Edit
            $(document).on("click", ".editProduk", function() {
                var id = $(this).data("id"); // Mendapatkan ID produk yang akan diedit

                // AJAX request untuk mengambil data produk berdasarkan ID
                $.ajax({
                    url: '<?= base_url('produk/tampil/')?>' + id,  // URL untuk mengambil data produk berdasarkan ID
                    type: 'GET',
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil.status == 'success') {
                            var produk = hasil.produk; // Menyimpan data produk ke dalam variabel

                            // Mengisi data ke form input modal edit
                            $("#editProdukId").val(produk.produk_id);  // Menyimpan ID produk di input hidden
                            $("#editNamaProduk").val(produk.nama_produk);  // Menyimpan nama produk di input
                            $("#editHarga").val(produk.harga);  // Menyimpan harga di input
                            $("#editStok").val(produk.stok);  // Menyimpan stok di input

                            // Menampilkan modal edit
                            $("#modalEditProduk").modal("show");
                        } else {
                            alert('Gagal mengambil data untuk diedit.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });

            // Fungsi untuk menyimpan perubahan data produk yang sudah diedit
            $("#updateProduk").on("click", function() {
                //var id = $("#editProdukId").val();  // Mendapatkan ID produk
                var formData = {
                    id : $("#editProdukId").val(),
                    nama_produk: $("#editNamaProduk").val(),  // Mendapatkan nama produk baru
                    harga: $("#editHarga").val(),  // Mendapatkan harga baru
                    stok: $("#editStok").val()   // Mendapatkan stok baru
                };

                // AJAX request untuk mengupdate data produk berdasarkan ID
                $.ajax({
                    url: '<?= base_url('produk/update')?>',  // URL untuk update produk berdasarkan ID
                    type: 'POST',  // Menggunakan metode PUT untuk update
                    data: formData,  // Data yang akan dikirim
                    dataType: 'JSON',
                    success: function(hasil) {
                        if (hasil.status == 'success') {
                            $("#modalEditProduk").modal("hide");  // Menutup modal edit setelah berhasil
                            tampilProduk();  // Memperbarui data produk di tabel
                            alert('Data berhasil diperbarui.');
                        } else {
                            alert('Gagal memperbarui data: ' + JSON.stringify(hasil.errors));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });

            // Hapus produk
            $(document).on("click", ".hapusProduk", function(){
                var id = $(this).data("id");
                if(confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
                    $.ajax({
                        url: '<?= base_url('produk/hapus')?>/' + id,
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(hasil) {
                            if (hasil.status == 'success') {
                                alert('Data berhasil dihapus.');
                                tampilProduk(); // Tampilkan ulang data produk
                            } else {
                                alert('Gagal menghapus data: ' + hasil.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan: ' + error);
                        }
                    });
                }
            });
        });

    </script>

    <script src="<?= base_url('assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>