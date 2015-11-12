<?php

namespace App\modules\customers\core\controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\modules\customers\core\models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller {
    /*
     * Renders a list with the clients
     */

    public function actionList() {
        view()->addLocation(app_path() . '/modules/customers/core/views');
        return view('list');
    }

    /*
     * Render's te create form view
     */

    public function actionNew() {
        view()->addLocation(app_path() . '/modules/customers/core/views');
        return view('new');
    }

    /*
     * Catches the post create request and executes it
     * 
     * @param {Request} $request - The request with the POST data
     */

    public function actionCreate(Request $request) {
        //catch all the data
        $data = $request->all();
        //create a empty object and fill it
        $customer = new Customer;
        foreach ($data as $key => $value) {
            if ($key != '_token')
                $customer->$key = $value;
        }
        //Save it to the database
        $customer->save();
        //Go to the 'view' view
        return redirect('/customers/view/' . $customer->id);
    }

    /*
     * The render view (to get client details) function
     * 
     * @param {Integer} $id - The cutomer's identifier 
     */

    public function actionView($id) {
        $customer = Customer::find($id);
        //Return the view
        view()->addLocation(app_path() . '/modules/customers/core/views');
        return view('view', ['customer' => $customer]);
    }

    /*
     * Renders the update form view
     * 
     * @param {Integer} $id - The cutomer's identifier 
     */

    public function actionModify($id) {
        $customer = Customer::find($id);
        //Return the view
        view()->addLocation(app_path() . '/modules/customers/core/views');
        return view('update', ['customer' => $customer]);
    }

    /*
     * Execute the update action and returns to the view page
     * 
     * @param {Request} $request - The POST request to process
     */

    public function actionUpdate(Request $request) {
        //catch all the data
        $data = $request->all();
        //create a empty object and fill it
        $customer = Customer::find($data['id']);
        if ($customer) {
            foreach ($data as $key => $value) {
                if ($key != '_token' && $key != 'id')
                    $customer->$key = $value;
            }
            //Save it to the database
            $customer->save();
            //Go to the 'view' view
            return redirect('/customers/view/' . $customer->id);
        }else{
            throw new \Exception('Customer not found');
        }
    }

}
