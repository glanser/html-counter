up:
	@docker-compose up -d && docker-compose exec --user=www-data  parser bash -c "composer install"
in:
	@docker-compose exec --user=www-data parser bash
count:
	@docker-compose exec --user=www-data  parser bash -c "./console count-tags $(url)"
test:
	@docker-compose exec --user=www-data  parser bash -c "./vendor/bin/phpunit"