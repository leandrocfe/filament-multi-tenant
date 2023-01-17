## Instalação

Clonar o repositório:

```bash
git clone https://github.com/leandrocfe/filament-multi-tenant.git
```

Acessar a pasta do repositório:

```bash
cd filament-multi-tenant
```

Copiar o arquivo env.example e nomear para .env:

```bash
cp .env.example .env
```

O projeto utiliza o Laravel Sail. Para mais informações, acesse [https://laravel.com/docs/9.x/sail](https://laravel.com/docs/9.x/sail).

Rode os seguintes comandos para instalar os pacotes necessários e configurar os serviços da aplicação:

```bash
composer install
sail up -d
```

Serviços utilizados:

-   laravel.test
-   mysql

Acesse o container do Mysql como root. Aplique as permissões necessárias para rodar os comandos com o user sail:

```sql
GRANT ALL PRIVILEGES on *.* to 'sail'@'%';
FLUSH PRIVILEGES;
```

Execute as migrações necessárias com o comando:

```bash
sail php artisan migrate --seed
```

A seguinte estrutura será criada:

-   [http://localhost/admin](http://localhost/admin) - Domínio central
    -   Database: _filament_multi_tenant_
    -   Credenciais: *admin@central.com / password*
-   [http://foo.localhost/admin](http://foo.localhost/admin) - Tenant foo
    -   Database: _tenant_foo_
    -   Credenciais: *admin@tenant.com / password*
-   [http://bar.localhost/admin](http://bar.localhost/admin) - Tenant bar
    -   Database: _tenant_bar_
    -   Credenciais: *admin@tenant.com / password*

Caso tenha alguma dúvida ou problema, envie um email: *leandrocfe@gmail.com*

## License

[MIT](https://choosealicense.com/licenses/mit/)
