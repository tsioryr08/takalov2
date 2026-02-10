# MINI-GUIDE GIT – PROJET EN TRINÔME

*(À lire AVANT de commencer à coder)*

## ⚠️ RÈGLE N°1 (OBLIGATOIRE)

❌ **NE JAMAIS TRAVAILLER SUR `main`**
✔️ **CHACUN travaille UNIQUEMENT sur SA branche**

## 🧑‍🤝‍🧑 Branches du projet

* `main` → version stable (⚠️ interdite au travail direct)
* `dev-tsiory` → branche Tsiory
* `dev-onja` → branche Onja
* `dev-njary` → branche Njary

# ✅ ÉTAPE 1 — Accepter l’invitation GitHub

1. Connectez-vous à GitHub
2. Cliquez sur votre photo de profil
3. **Settings / Invitations**
4. Cliquez **Accept invitation**

👉 Sans ça, vous ne pouvez rien faire.

# ✅ ÉTAPE 2 — Cloner le projet (UNE FOIS)

Dans le terminal :

```
git clone https://github.com/tsioryr08/takalov2.git
cd takalov2
```

# ✅ ÉTAPE 3 — Aller sur VOTRE branche (TRÈS IMPORTANT)

### 🔹 Onja :

```
git checkout dev-onja
```

### 🔹 Njary :

```
git checkout dev-njary
```

⚠️ **Ne restez jamais sur `main`**

# 👀 Comment vérifier sur quelle branche vous êtes

```
git branch
```

➡️ La branche avec `*` est celle où vous travaillez.

Dans **VS Code** :
👉 regardez **en bas à gauche**, le nom de la branche est affiché.

# 🔄 ÉTAPE 4 — AVANT de coder (obligatoire à chaque session)

```
git pull origin main
```

👉 Ça récupère le travail des autres.

# ✏️ ÉTAPE 5 — Travailler normalement

* Codez dans VS Code
* Sauvegardez vos fichiers

Quand vous avez fini une partie :

```
git add .
git commit -m "description claire de ce que vous avez fait"
git push
```

👉 Le travail est sauvegardé **sur votre branche**

# 🔥 ÉTAPE 6 — Envoyer votre travail dans `main`

⚠️ **NE PAS MERGE EN LOCAL**

1. Allez sur GitHub
2. Cliquez **Compare & Pull Request**
3. Base : `main`
4. Compare : *votre branche*
5. Message clair
6. Cliquez **Create Pull Request**

👉 Le groupe valide puis merge.

# 🚫 INTERDICTIONS

❌ `git push` sur `main`
❌ travailler à plusieurs sur la même branche
❌ supprimer une branche sans accord

# 🧠 À retenir

✔️ 1 personne = 1 branche
✔️ `main` = version finale
✔️ Assemblage = Pull Request
✔️ Toujours `git pull origin main` avant de coder

# 🎯 Résumé ultra simple

> **Tu travailles sur TA branche → tu pushes → tu fais une Pull Request → le projet est assemblé proprement**

Bon courage à l’équipe 💪
