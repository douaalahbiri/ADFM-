CREATE TABLE `user` (
  `CIN` int(12) NOT NULL COMMENT 'votre cin',
  `nom` varchar(110) NOT NULL,
  `prénom` varchar(110) NOT NULL,
  `email` varchar(300) NOT NULL,
  `téléphone` varchar(100) NOT NULL,
  `mot de passe` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`CIN`, `nom`, `prénom`, `email`, `téléphone`, `mot de passe`) VALUES
(12987, 'lahbiri', 'douaa', 'douaalahbiri@gmail.com', '0729262618', 'douaa123'),
(123234, 'ennasiry', 'aya', 'ayaennasiry@gmail.com', '0634836279', 'aya123'),
(835374, 'darij', 'mariem', 'mariemdarij@gmail.com', '0634846281', 'mariem123'),
(935274, 'benchahbi', 'fatima-ezzahrae', 'benchahbifatima-ezzahrae@gmail.com', '0627384982', 'fati123');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`CIN`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `CIN` int(12) NOT NULL AUTO_INCREMENT COMMENT 'votre cin', AUTO_INCREMENT=935275;
COMMIT;
