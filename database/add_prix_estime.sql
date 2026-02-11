-- Script pour ajouter la colonne prix_estime à la table objet existante
USE takalo;

-- Ajouter la colonne prix_estime (ignorer l'erreur si elle existe déjà)
ALTER TABLE objet 
ADD COLUMN prix_estime DECIMAL(10,2) DEFAULT NULL AFTER disponible;
