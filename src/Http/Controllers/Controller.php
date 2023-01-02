<?php

namespace Rklab\Crud\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use JetBrains\PhpStorm\Pure;
use Rklab\Crud\Http\Controllers\Repository\Repository;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    #[Pure] public function getCrudFactory(): CrudFactory
    {
        return new CrudFactory();
    }

    #[Pure] public function getRepository(): Repository
    {
        return new Repository();
    }

    public function indexPagination(): View
    {
        $config = $this->getCrudFactory()->createCrudConfig();

        $crudListPagination = $config->getCrudListPagination();
        $relationshipListPagination = $config->getRelationshipListPaginaton();
        $crudElementsPagination = $config->getCrudElementPagination();

        return view('crud::dashboard.pagination')->with(compact('crudListPagination', 'relationshipListPagination', 'crudElementsPagination'));
    }

    public function setPagination(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'crud_list_pagination' => 'numeric|min:1|max:100',
            'relationships_list_pagination' => 'numeric|min:1|max:100',
            'crud_elements_pagination' => 'numeric|min:1|max:100',
        ]);

        $params['pagination'] = $request->except(['_token']);
        $jsonData = json_encode($params);

        file_put_contents(__DIR__.'/Config/config.json', $jsonData);

        return redirect()->route('dashboard')->with('success', 'Pagination has been set!');
    }
}
