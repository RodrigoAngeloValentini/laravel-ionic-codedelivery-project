## LARAVEL 5.1 COM IONIC + CORDOVA - BF

Problemas:

#Middleware: CheckRole()
Auth::check() e Auth::user() não estão funcionando

#Create e Edit Clients

#Erro ao criar seed ordem item
Unable to locate factory with name [default] [OrdermItem].
Mesmo com isso: 
$factory->define(CodeDelivery\Models\OrderItem::class, function (Faker\Generator $faker) {
    return [];
});

#Não edita entragador pedido
--