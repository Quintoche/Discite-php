#!/bin/bash

# Nom du dépôt distant (à adapter si nécessaire)
REMOTE_URL=$(git remote get-url origin)

echo "⚠️ This will ERASE the entire Git history of the repository."
read -p "Are you sure? (y/n): " CONFIRM

if [[ "$CONFIRM" != "y" ]]; then
  echo "❌ Operation cancelled."
  exit 1
fi

echo "🧹 Removing current .git history..."
rm -rf .git

echo "🔁 Reinitializing Git..."
git init
git add .
git commit -m "Initial commit"

echo "🔗 Re-adding remote origin: $REMOTE_URL"
git remote add origin "$REMOTE_URL"

echo "🚀 Forcing push to overwrite remote history..."
git branch -M main
git push -f origin main

echo "✅ Git history reset complete. 'Initial commit' pushed."
