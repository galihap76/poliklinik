
use Eksis_RB

select kdjabatan,namajabatan from jabpemeriksa
where kdjabatan in(1,20)


select * from jabpemeriksa


select * from poliklinik

select * from dip WHERE norm = '062183'

select * from pasienmasuk

select a.kdjabatan, a.namapemeriksa from pemeriksa a
inner join pasienmasuk b on b.nopemeriksa = a.nopemeriksa


select norm, namapasien, a.tanggallahir, a.alamat, c.namapemeriksa, c.nopemeriksa from dip









select * from pemeriksa
select * from pasienmasuk
select * from jabpemeriksa

select a.norm, a.namapasien, a.tanggallahir, a.alamat, c.namapemeriksa, c.nopemeriksa from dip a
inner join pasienmasuk b on b.nopendaftaran=a.nopendaftaran
inner join pemeriksa c on c.nopemeriksa = b.nopemeriksa
inner join jabpemeriksa d on d.kdjabatan = c.kdjabatan
where d.kdjabatan = 1 and c.namapemeriksa = 'dr. Sutarto Hadisumartono, Sp.A' and a.tanggaldaftar='2017-07-11'






SELECT DISTINCT norm, namapasien
FROM dip
WHERE norm = '062387'

SELECT DISTINCT norm, namapasien
FROM dip
WHERE norm = '060556'


CREATE TABLE tbl_soap (
  id int NOT NULL,
  norm char(6) NOT NULL,
  tanggal datetime NOT NULL,
  dir_jpg varchar(200) NOT NULL,
  PRIMARY KEY (id)
)

select * from tbl_soap
delete from tbl_soap

INSERT INTO tbl_soap (id, norm, tanggal, dir_jpg) VALUES (1, '000111', GETDATE(), 'ya')














inner join jabpemeriksa d on d.kdjabatan = c.kdjabatan
where d.kdjabatan = 20 and c.namapemeriksa = 'dr. Octaviana Y, Sp.OG' and a.tanggaldaftar='2017-07-11'

where a.tanggaldaftar='2017-07-11' and b.nopemeriksa=7 
where a.tanggaldaftar='2017-07-11' and b.nopemeriksa=7 and c.namapemeriksa = 'dr. Octaviana Y, Sp.OG' and jab


where c.kdjabatan = 20 and c.namapemeriksa = 'dr. Septiana, Sp.A, M.Kes'



select norm, namapemeriksa from dip where nopemeriksa = 7









select a.norm, a.namapasien, a.tanggallahir from dip a
inner join pasienmasuk b on b.nopendaftaran=a.nopendaftaran
inner join pemeriksa c on c.nopemeriksa = b.nopemeriksa
inner join jabpemeriksa d on d.kdjabatan = 'dr. Parjito, Sp.OG'
where  tanggaldaftar='2023-06-15' and b.nopemeriksa=4 


select * from pasienmasuk
select nopendaftaran from dip
select nopemeriksa, namapemeriksa, kdjabatan from pemeriksa

select

SELECT pemeriksa.NAMAPEMERIKSA FROM pemeriksa
INNER JOIN jabpemeriksa ON pemeriksa.KDJABATAN = jabpemeriksa.KDJABATAN
WHERE jabpemeriksa.KDJABATAN = 1



inner join jabpemeriksa d on d.kdjabatan = c.nopemeriksa