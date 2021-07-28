<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 4 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h1>My First Bootstrap Page</h1>
  <p>This is some text.</p> 
</div>

<script>
    $.get('data.json',function(data){
        var query='INSERT INTO `siswa`(`nis`, `username`, `nama`, `alamat`, `tempat_lahir`, `tgl_lahir`, `jk`, `agama`, `no_telp`, `email`, `gambar`) VALUES ';
        // $.each(data.siswa.kelas_vii.b, function(i,item){
        //     var name= item.nama.replace(/'/g, '\'')
        //     query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        // })
        // $.each(data.siswa.kelas_vii.c, function(i,item){
        //     var name= item.nama.replace(/'/g, "\'")
        //     query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        // })
        // $.each(data.siswa.kelas_vii.d, function(i,item){
        //     var name= item.nama.replace(/'/g, "\'")
        //     query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        // })
        // $.each(data.siswa.kelas_vii.e, function(i,item){
        //     var name= item.nama.replace(/'/g, "\'")
        //     query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        // })
        // $.each(data.siswa.kelas_vii.f, function(i,item){
        //     var name= item.nama.replace(/'/g, "\'")
        //     query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        // })
        $.each(data.siswa.kelas_vii.g, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_viii.a, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_viii.b, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_viii.c, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_viii.d, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_viii.e, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_viii.f, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_viii.g, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_ix.a, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_ix.b, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_ix.c, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_ix.d, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_ix.e, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_ix.f, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        $.each(data.siswa.kelas_ix.g, function(i,item){
            var name= item.nama.replace(/'/g, "\'")
            query += `('${item.nis}', '${item.nis}', '${name}', '${item.alamat}', '${item.tempat_lahir}', '${item.tgl_lahir}', '${item.jk}', '${item.agama}', '${item.no_telp}', '${item.email}', 'NULL'),`
        })
        
        $('.container').html(query)
        console.log(query)
    },'json')
</script>
</body>
</html>