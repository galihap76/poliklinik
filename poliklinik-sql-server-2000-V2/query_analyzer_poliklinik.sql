
use Eksis_RB

select kdjabatan,namajabatan from jabpemeriksa
where kdjabatan in(1,20)


select * from jabpemeriksa


select * from poliklinik

select * from dip WHERE norm = '062183'

select * from pasienmasuk

select a.kdjabatan, a.namapemeriksa from pemeriksa a
inner join pasienmasuk b on b.nopemeriksa = a.nopemeriksa


select * from pemeriksa
select * from pasienmasuk
select * from jabpemeriksa

select a.norm, a.namapasien, a.tanggallahir, a.alamat, c.namapemeriksa, c.nopemeriksa from dip a
inner join pasienmasuk b on b.nopendaftaran=a.nopendaftaran
inner join pemeriksa c on c.nopemeriksa = b.nopemeriksa
inner join jabpemeriksa d on d.kdjabatan = c.kdjabatan
where d.kdjabatan = 1 and c.namapemeriksa = 'dr. Sutarto Hadisumartono, Sp.A' and a.tanggaldaftar='2017-07-11'



select * from tbl_soap
select * from tbl_resep


delete from tbl_soap
delete from tbl_resep
 
