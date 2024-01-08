CREATE SCHEMA IF NOT EXISTS `projeto_final_logins` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
use `projeto_final_logins`;

create table if not exists tb_admins(
cod_admin INT PRIMARY KEY AUTO_INCREMENT,
nome VARCHAR(45) NOT NULL,
email VARCHAR(45),
password VARCHAR(45)
);

insert into tb_admins (nome, email, password) values 
('pedro', 'pedro@cencal.pt', 'pedrocencal123'),
('ricardo', 'ricardo@cencal.pt', 'ricardocencal123'),
('carla','carla@cencal.pt','carlacencal123'),
('marco','marco@cencal.pt','marcocencal123');