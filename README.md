# RouterModule
Riesi dynamicke pridavanie rout do applikacie. Obsahuje register do ktoreho sa daju praidavat defaultne nastavenia pre routy.

```
class RestApiRouterEntity {

	public static function create() {
		$entity = new RouterEntity();
		$entity->route = "[<lang>/]api/[v<apiVersion>/]<apiResource>";
		$entity->module = "RestApi";
		$entity->presenter = "RestApi";
		$entity->action = "default";
		$entity->defaults = [
			"apiVersion" => 1,
			"apiResource" => NULL
		];
		$entity->sort = 20;
		$entity->sitemap = false;
		$entity->status = 1;
		return $entity;
	}

}
```

A do prislusneho registru sa prida:
```
services:
	defaultRoutesRegister:
		setup:
		- add(Wame\RestApiModule\Vendor\Core\Registers\RestApiRouterEntity::create(), 'api')
```

Pre pridanie vsetkych defaultnych rout je potrebne spustit prikaz
```
php index.php router:update-default-routes
```