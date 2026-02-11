#!/bin/bash

# Script pour initialiser la base de données users
# Usage: ./init_users_db.sh

echo "📦 Initialisation de la table users..."
echo ""

# Demander le mot de passe MySQL
read -sp "Entrez le mot de passe MySQL root: " MYSQL_PWD
echo ""

# Exécuter le script SQL
mysql -u root -p"$MYSQL_PWD" takalo < database/create_users_table.sql

if [ $? -eq 0 ]; then
    echo "✅ Table users créée avec succès!"
    echo ""
    echo "Compte test disponible:"
    echo "  Email: test@example.com"
    echo "  Password: password"
else
    echo "❌ Erreur lors de la création de la table"
    exit 1
fi
