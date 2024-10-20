<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permissões do comprador
        $favoriteProducts = Permission::create(['name' => 'favorite products']); // favoritar produtos 
        $buyProducts = Permission::create(['name' => 'buy products']); // comprar produtos 
        $evaluateProducts = Permission::create(['name' => 'evaluate products']); // avaliar produtos 
        $purchaseHistory = Permission::create(['name' => 'purchase history']); // historico de compras 

        // Permissões do vendedor
        $createProducts = Permission::create(['name' => 'manage products']); // criar seus produtos
        $systemSroducts = Permission::create(['name' => 'manage all products']); // revende os produtos do sistema
        $salesHistory = Permission::create(['name' => 'sales history']); // historico de vendas

        // Permissões do admin
        $productManagement = Permission::create(['name' => 'product management']); // gerenciar produtos
        $createsSystemProducts = Permission::create(['name' => 'create system products']); // criar produtos do sistema
        $manageBuyerSeller = Permission::create(['name' => 'manage buyer and seller']); // gerenciar compradores e vendedores
        $approveSeller = Permission::create(['name' => 'approve seller']); // aprovar vendedores

        
        $buyer = Role::create(['name' => 'seller']);
        $buyer->givePermissionTo([ $buyProducts, $favoriteProducts, $evaluateProducts, $purchaseHistory ]);
        
        $seller = Role::create(['name' => 'seller']);
        $seller->givePermissionTo([ $createProducts, $systemSroducts, $salesHistory ]);
        
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([ $productManagement, $createsSystemProducts, $manageBuyerSeller, $approveSeller ]);
    }
}
