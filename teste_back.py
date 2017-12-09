import sqlite3
#criar conn
conn = sqlite3.connect("db_customers")
c = conn.cursor()

#criar table
c.executescript("""
    CREATE TABLE IF NOT EXISTS tb_customer_account (
        id_customer INT PRIMARY KEY NOT NULL,
        cpf_cnpj TEXT NOT NULL,
        nm_customer TEXT NOT NULL,
        is_active INT NOT NULL,
        vl_total REAL NOT NULL
    )""")

#inserir valores
data_insert = (
    (1000,'466.192.168-31','Lucas Henrique',1,325),
    (1300,'192.168.150-15','Jose Antonio',1,510),
    (1700,'571.156.845-46','Marcio da Silva',0,120),
    (2400,'984.256.152-75','Paloma Oliveira',1,650),
    (3000,'841.963.356.65','Aline da Silva',0,850)
)
c.executemany("INSERT INTO tb_customer_account VALUES (?,?,?,?,?)", data_insert)

#select data
c.execute("SELECT COUNT(*) FROM tb_customer_account WHERE vl_total > 560 AND id_customer >= 1500 AND id_customer <= 2700 ORDER BY vl_total DESC")
rowcount = c.fetchone()[0]
c.execute("SELECT * FROM tb_customer_account WHERE vl_total > 560 AND id_customer >= 1500 AND id_customer <= 2700 ORDER BY vl_total DESC")
data_fetch = c.fetchall()

def calcMedia():
    media = 0
    for row in data_fetch:
        media += row[4]
    media = media/rowcount
    return media

print('Media: ',calcMedia())
print('\nSaldo\tNome')

for row in data_fetch:
    print(row[4],'\t',row[2])
