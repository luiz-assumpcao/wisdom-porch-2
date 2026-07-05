CREATE DATABASE IF NOT EXISTS wisdom_porch;
USE wisdom_porch;

DROP TABLE IF EXISTS assinante;
DROP TABLE IF EXISTS escola;
DROP TABLE IF EXISTS administrador;

CREATE TABLE escola (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_escola VARCHAR(60),
    descricao VARCHAR(255)
);

CREATE TABLE administrador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(30) UNIQUE NOT NULL,
    senha CHAR(32) NOT NULL
);

CREATE TABLE assinante (
    id INT AUTO_INCREMENT PRIMARY KEY,
    primeiro_nome VARCHAR(30) NOT NULL,
    email VARCHAR(120) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    data_nascimento DATE,
    id_escola INT NOT NULL,
    data_inscricao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_escola) REFERENCES escola(id)
);

INSERT INTO escola (nome_escola, descricao) VALUES
('Stoicism', 'A philosophy of virtue, reason, and acceptance of what is beyond our control.'),
('Existentialism', 'Explores individual freedom, choice, and the search for meaning in an indifferent universe.'),
('Skepticism', 'Questions the possibility of certain knowledge and encourages suspension of judgment.'),
('Nihilism', 'Holds that life lacks inherent meaning, purpose, or intrinsic value.'),
('Epicureanism', 'Pursues modest pleasure, friendship, and freedom from fear as the path to a good life.'),
('Cynicism', 'Rejects social conventions and material wealth in favor of a simple, virtuous life.'),
('Platonism', 'Centers on the theory of Forms, holding that abstract ideals are the truest reality.'),
('Aristotelianism', 'Emphasizes empirical observation, logic, and virtue as habituated excellence.'),
('Rationalism', 'Holds that reason, not sensory experience, is the primary source of knowledge.'),
('Empiricism', 'Argues that knowledge arises primarily from sensory experience and observation.'),
('Utilitarianism', 'Judges actions by their consequences, favoring the greatest good for the greatest number.'),
('Deontology', 'Holds that the morality of an action depends on adherence to rules or duties.'),
('Absurdism', 'Explores the conflict between the human search for meaning and a meaningless universe.'),
('Pragmatism', 'Evaluates ideas and beliefs by their practical consequences and usefulness.'),
('Phenomenology', 'Studies structures of consciousness and subjective experience as they are lived.'),
('Idealism', 'Holds that reality is fundamentally mental or dependent upon the mind.'),
('Materialism', 'Holds that only physical matter and its interactions constitute reality.'),
('Confucianism', 'Emphasizes moral virtue, social harmony, and respect for family and tradition.'),
('Taoism', 'Teaches living in harmony with the natural flow of the universe, or Tao.'),
('Humanism', 'Centers human values, reason, and dignity as the foundation for ethics and meaning.'),
('Other', NULL);

INSERT INTO assinante (primeiro_nome, email, telefone, data_nascimento, id_escola) VALUES
('Marina', 'marina.silva@example.com', '5541987654321', '1994-03-12', (SELECT id FROM escola WHERE nome_escola = 'Stoicism' LIMIT 1)),
('Lucas', 'lucas.pereira@example.com', '5511998765432', '1988-07-25', (SELECT id FROM escola WHERE nome_escola = 'Existentialism' LIMIT 1)),
('Beatriz', 'beatriz.costa@example.com', '5521987651234', '2001-11-02', (SELECT id FROM escola WHERE nome_escola = 'Skepticism' LIMIT 1)),
('Rafael', 'rafael.souza@example.com', '5531988123456', '1996-05-19', (SELECT id FROM escola WHERE nome_escola = 'Nihilism' LIMIT 1)),
('Camila', 'camila.oliveira@example.com', '5551987231456', '1999-01-30', (SELECT id FROM escola WHERE nome_escola = 'Other' LIMIT 1)),
('Thiago', 'thiago.almeida@example.com', '5541998877665', '1985-09-08', (SELECT id FROM escola WHERE nome_escola = 'Epicureanism' LIMIT 1)),
('Larissa', 'larissa.gomes@example.com', '5511987654123', '1992-12-14', (SELECT id FROM escola WHERE nome_escola = 'Cynicism' LIMIT 1)),
('Gustavo', 'gustavo.ribeiro@example.com', '5521998456789', '1990-04-22', (SELECT id FROM escola WHERE nome_escola = 'Platonism' LIMIT 1)),
('Fernanda', 'fernanda.martins@example.com', '5531987456123', '2000-06-17', (SELECT id FROM escola WHERE nome_escola = 'Aristotelianism' LIMIT 1)),
('Bruno', 'bruno.carvalho@example.com', '5541988654987', '1987-08-03', (SELECT id FROM escola WHERE nome_escola = 'Rationalism' LIMIT 1)),
('Juliana', 'juliana.rocha@example.com', '5551998321654', '1998-02-27', (SELECT id FROM escola WHERE nome_escola = 'Empiricism' LIMIT 1)),
('Diego', 'diego.barbosa@example.com', '5511987321987', '1993-10-09', (SELECT id FROM escola WHERE nome_escola = 'Utilitarianism' LIMIT 1)),
('Patricia', 'patricia.lima@example.com', '5521988765123', '1989-03-15', (SELECT id FROM escola WHERE nome_escola = 'Deontology' LIMIT 1)),
('Rodrigo', 'rodrigo.nunes@example.com', '5531998123789', '1995-07-21', (SELECT id FROM escola WHERE nome_escola = 'Absurdism' LIMIT 1)),
('Vanessa', 'vanessa.freitas@example.com', '5541987789456', '1997-11-11', (SELECT id FROM escola WHERE nome_escola = 'Pragmatism' LIMIT 1)),
('Eduardo', 'eduardo.pinto@example.com', '5551988456321', '1991-05-05', (SELECT id FROM escola WHERE nome_escola = 'Phenomenology' LIMIT 1)),
('Renata', 'renata.correia@example.com', '5511998234567', '1986-09-29', (SELECT id FROM escola WHERE nome_escola = 'Idealism' LIMIT 1)),
('Felipe', 'felipe.dias@example.com', '5521987123654', '1994-12-24', (SELECT id FROM escola WHERE nome_escola = 'Materialism' LIMIT 1)),
('Amanda', 'amanda.teixeira@example.com', '5531988987321', '2002-01-08', (SELECT id FROM escola WHERE nome_escola = 'Confucianism' LIMIT 1)),
('Vinicius', 'vinicius.moreira@example.com', '5541998321789', '1984-06-30', (SELECT id FROM escola WHERE nome_escola = 'Taoism' LIMIT 1));