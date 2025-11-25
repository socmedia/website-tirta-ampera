# Contributing to SOC Software House Boilerplate

Thank you for considering contributing to this project! We welcome pull requests, issues, and suggestions that improve our codebase and documentation.

## Guidelines

### 1. **Code of Conduct**

Please review our [Code of Conduct](./CODE_OF_CONDUCT.md) before participating. We expect all contributors to act respectfully and professionally.

### 2. **Issues**

* Search [existing issues](https://github.com/your-repo/issues) before opening a new one.
* Provide a clear and descriptive title.
* Include screenshots, logs, or stack traces if relevant.
* Label the issue accordingly (bug, feature, enhancement, question, etc.).

### 3. **Pull Requests**

#### When submitting a PR:

* Fork the repo and create a new branch:
  `git checkout -b feature/your-feature-name`
* Follow **PSR-12** for PHP and **Prettier/Tailwind conventions** for frontend code.
* Include a clear description of what the PR changes and why.
* Reference the related issue (if any):
  `Fixes #123` or `Closes #123`
* Add tests if applicable.
* Run `php artisan test` and `npm run lint` before submitting.

#### Don’t:

* Submit PRs to the `main` or `production` branches directly.
* Commit unrelated changes in one PR.

### 4. **Environment Setup**

```bash
git clone https://github.com/socsoftwarehouse/project-name.git
cd project-name
cp .env.example .env
composer install
npm install
php artisan key:generate
```

## Testing

```bash
php artisan test      # Runs PHP unit tests
npm run dev           # Compiles assets for local testing
```

## Discussions

* For feature ideas or architectural questions, use [Discussions](https://github.com/your-repo/discussions).
* For bugs or errors, use [Issues](https://github.com/your-repo/issues).

## Contributor License Agreement

By submitting code, you agree that your contributions will be licensed under the same license as the project: [MME License](./LICENSE.md).

## Thank You!

Your contributions are valued and appreciated — every issue, suggestion, or PR helps us improve.

Happy coding!
— The SOC Software House Team
