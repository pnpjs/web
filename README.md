## Installation/configuration

1. Copy the following files into the root of your Bedrock project:
  * `Capfile`
  * `Gemfile`
  * `Gemfile.lock`
2. Copy the following files/folders into your `config` directory:
  * `config/deploy/*`
  * `config/deploy.rb`
3. Edit your `config/deploy/` stage/environment configs to set the roles/servers and connection options.
4. Before your first deploy, run `bundle exec cap <stage> deploy:check` to create the necessary folders/symlinks.
5. Add your `.env` file to `shared/` in your `deploy_to` path on the remote server for all the stages you use (ex: `/srv/www/example.com/shared/.env`)
6. Run the normal deploy command: `bundle exec cap <stage> deploy`
7. Enjoy one-command deploys!

## Usage

* Deploy: `cap production deploy`
* Rollback: `cap production deploy:rollback`

Composer support is built-in so when you run a deploy, `composer install` is automatically run. Capistrano has a great [deploy flow](http://www.capistranorb.com/documentation/getting-started/flow/) that you can hook into and extend it.
