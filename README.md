# 🛡️ SecureWeb — Plateforme web sécurisée

<p align="left">
  <img src="https://img.shields.io/badge/PHP-8.2+-0D0D0D?style=flat-square&logo=php&logoColor=A855F7" alt="PHP" />
  <img src="https://img.shields.io/badge/Symfony-7-0D0D0D?style=flat-square&logo=symfony&logoColor=A855F7" alt="Symfony" />
  <img src="https://img.shields.io/badge/MySQL-8-0D0D0D?style=flat-square&logo=mysql&logoColor=A855F7" alt="MySQL" />
  <img src="https://img.shields.io/badge/Sécurité-OWASP-A855F7?style=flat-square&logo=owasp&logoColor=white" alt="OWASP" />
  <img src="https://img.shields.io/badge/Statut-En%20cours-8A2BE2?style=flat-square" alt="Statut" />
</p>

Application web complète dont l'objectif est simple : **prouver qu'on peut développer
une plateforme fonctionnelle tout en appliquant les bonnes pratiques de sécurité dès la conception.**

## ✨ Fonctionnalités

- [x] Inscription / connexion avec hachage salé des mots de passe (Argon2id)
- [x] Filtrage et validation systématique des entrées utilisateur
- [x] Requêtes préparées (Doctrine) contre les injections SQL
- [x] Protection CSRF sur tous les formulaires
- [x] Détection et blocage des tentatives d'accès suspectes (rate limiting)
- [x] Tableau de bord de surveillance des connexions
- [x] Journalisation des actions et des erreurs
- [ ] Authentification à deux facteurs (TOTP)
- [ ] Tests automatisés (PHPUnit) + analyse statique (PHPStan)

## 🧱 Architecture

```text
src/
├── Controller/        # Routes et endpoints
├── Entity/            # Entités Doctrine (User, LoginAttempt, AuditLog)
├── Repository/        # Accès aux données (requêtes préparées)
├── Security/          # Authenticators, voters, listeners
├── Service/           # Logique métier (détection d'anomalies, logs)
├── Form/              # Formulaires + validation
└── EventListener/     # Journalisation et blocage des IP suspectes

config/
├── packages/security.yaml
└── routes.yaml

templates/             # Twig (dashboard, auth, logs)
tests/                 # Tests fonctionnels et unitaires
migrations/            # Schéma MySQL versionné
```

## 🔐 Mesures de sécurité implémentées

| Menace | Contre-mesure |
|:--|:--|
| Vol de mot de passe | Hachage **Argon2id** + sel unique, politique de complexité |
| Injection SQL | **Requêtes préparées** via Doctrine ORM, aucune concaténation SQL |
| XSS | Échappement automatique Twig, en-têtes CSP |
| CSRF | Jetons CSRF Symfony sur chaque formulaire |
| Brute force | Rate limiting + verrouillage temporaire du compte |
| Session hijacking | Cookies `HttpOnly`, `Secure`, `SameSite=Strict`, régénération d'ID |
| Fuite d'informations | Messages d'erreur génériques, logs internes détaillés |

## 🚀 Installation

```bash
git clone https://github.com/MolkaHassine/secureweb.git
cd secureweb
composer install
cp .env.example .env
# Configurer DATABASE_URL dans .env
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console app:create-admin
symfony server:start
```

## 🧪 Tests & qualité

```bash
php bin/phpunit
vendor/bin/phpstan analyse
php bin/console lint:twig templates
```

## 🗺️ Roadmap

- [ ] Mise en ligne d'une démo (hébergement + base de données)
- [ ] 2FA TOTP
- [ ] Export CSV des logs d'audit
- [ ] Intégration Docker Compose (PHP-FPM, MySQL, Nginx)
- [ ] Audit de sécurité documenté (avant/après)

## ⚠️ Usage

Projet pédagogique. Ne jamais déployer une application de démonstration en production
sans audit de sécurité indépendant.

## 📬 Contact

Molka Hassine — [molka.hassine@polytechnicien.tn](mailto:molka.hassine@polytechnicien.tn)

## 📄 Licence

MIT — voir [LICENSE](../../LICENSE).
