{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-10">
            <div class="col-xl">
                <canvas id="avgChart" class="visual"></canvas>
                <br>
                <canvas id="countChart" class="visual"></canvas>
            </div>
        </div>
        <div class="row mb-3">

            <div class="col-sm-6 mx-auto">
                <canvas id="myChart" class=""></canvas>
            </div>

        </div>
    </div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-auto align-self-center">
            <h5>Halaman Support</h5>
        </div>
        <div class="row">
            <div class="col">
                <img src="\images\support.png" class="img-fluid" alt="Woman sitting in front of a laptop computer">
                <h4 class="mt-4 text-center">Butuh bantuan Penggunaan SIMANJA ?</h4>
                <div class="row  text-center">
                    <div class="col px-0">
                        <a href="#"><i class="bi bi-whatsapp"></i> +6282133985486</a>
                        <a href="#"><i class="bi bi-envelope px-3"> restuilham212@gmail.com</i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mt-4" style="background: white;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="\images\video_tutorial.png" class="img-fluid" alt="video tutorial" width="75"
                                    height="75">
                            </div>
                            <div class="col">
                                <h5 class="card-title"><strong>Video Tutorial</strong></h5>
                                <p class="card-text">Informasi tentang video tutorial di sini.</p>
                            </div>
                        </div>
                        <br>
                        <a href="#" class="btn btn-custom">Lihat lebih lanjut</a>
                    </div>
                </div>
                <div class="card mt-4" style="background: white;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="\images\dokumentasi.png" class="img-fluid" alt="video tutorial" width="75"
                                    height="75">
                            </div>
                            <div class="col">
                                <h5 class="card-title"><strong>Dokumentasi Penggunaan SIMANJA</strong></h5>
                                <p class="card-text">Informasi tentang dokumentasi penggunaan SIMANJA di sini.</p>
                            </div>
                        </div>
                        <br>
                        <a href="#" class="btn btn-custom">Lihat lebih lanjut</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="accordion mt-4">
            <h4 class="mt-4">Frequently Asked Question</h4>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapse" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Bagaimana caranya untuk mengganti password akun SIMANJA ?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        Untuk mengganti password akun silahkan untuk mengklik " reset your password ? " pada halaman login.
                        Kemudian isikan email akun pengguna. lalu nanti akan ada email yang berisikan link untuk mereset
                        password.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Bagaimana caranya untuk membuat pekerjaan untuk pegawai ?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        Pengguna perlu berada pada halaman progress tim ketua. kemudian silahkan untuk mengklik tombol "
                        tambah pekerjaan ". Isikan yang perlu diisikan seperti memilih jenis pekerjaan dan target serta
                        pegawai yang ingin diberikan pekerjaan. kemudian klik simpan makan pekerjaan berhasil dibuat.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTiga">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTiga" aria-expanded="false" aria-controls="collapseTiga">
                        Bagaimana caranya untuk mengeksport pekerjaan berdasarkan bulan yang diinginkan ?
                    </button>
                </h2>
                <div id="collapseTiga" class="accordion-collapse collapse" aria-labelledby="headingTiga"
                    data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        Pengguna perlu berada pada halaman progress tim ketua. kemudian silahkan untuk memilih bulan dan
                        tahun yang terletak di atas tabel kemudian klik filter. lalu user memilih tombol "export" dan
                        berhasil.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Bagaimana caranya untuk mengimport pekerjaan supaya lebih mudah dalam memploting pekerjaan tiap
                        pegawai ?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        Ketua tim silahkan untuk mendownload template excel pada icon download ketika sudah mengklik tombol
                        " import ". kemudian isikan sesuai yang diinginkan lalu setelah selesai kembali lagi ke jendela baru
                        tadi dan pilih file excelnya lalu import.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Bagaimana caranya untuk mengupload pekerjaan ?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                    data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        Pegawai perlu berada di halaman pekerjaan. kemudian setiap pekerjaan di bagian kolom realisasi
                        terdapat icon + . klik icon tersebut dan akan membuka tab pop up lalu isikan dan upload bukti
                        pekerjaan lalu simpan. setelah berhasil tunggu konfirmasi dari ketua tim.
                        Jika tidak ada tanda icon + dikarenakan sudah melewati H+3 deadline pekerjaan tersebut sehingga
                        ditutup.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        Bagaimana caranya untuk menilai pekerjaan pegawai?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                    data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        Untuk menilai pegawai bagi ketua tim silahkan untuk berada di halaman progress tim ketua. kemudian
                        klik tombol centang hijau lalu akan muncul tab pop up dan silahkan untuk menilai pekerjaan tersebut.
                        icon centang hijau akan muncul ketika pekerjaan tersebut sudah dikerjakan oleh pegawai.
                    </div>
                </div>
            </div>
            <!-- tambahkan item FAQ lainnya di sini -->
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.4.0/js/dataTables.rowGroup.min.js"></script>

    <link rel="stylesheet" href=" https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
@endsection
