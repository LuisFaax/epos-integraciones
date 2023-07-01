<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Delivery;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;

    public $search, $records,  $editing, $action = 1, $customerSelected;
    public Customer $customer; // propiedad de tipo Customer
    public $delivery; // databinding / vinculacion de datos anidados con la notacion dot

    protected $rules =
    [
        'customer.first_name' => "required|min:3|max:35",
        'customer.last_name' => "nullable|min:3|max:35",
        'customer.email' => "nullable|max:65|email",
        'customer.phone' => "nullable|min:7|max:15",
        'customer.platform_id' => 'nullable'
    ];

    protected $paginationTheme = 'bootstrap';


    public function mount()
    {
        $this->customer = new Customer(); // hacemos que la propiedad customer sea una instancia del modelo
        $this->editing = false;

        $this->delivery = [
            'type' => 'billing',
        ];
    }

    protected $listeners = [
        'refresh' => '$refresh',
        'search' => 'searching',
        'Destroy'
    ];


    public function render()
    {
        return view('livewire.customers.customers', [
            'customers' => $this->loadCustomers()
        ]);
    }

    public function loadCustomers()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = Customer::where('first_name', 'like', "%{$this->search}%")
                ->orWhere('last_name', 'like', "%{$this->search}%")
                ->orderBy('first_name', 'asc')
                ->paginate(5);
        } else {
            $query =  Customer::with('deliveries')->orderBy('last_name', 'asc')->paginate(5);
        }

        $this->records = $query->total();

        return $query;
    }

    public function searching($searchText)
    {
        $this->search = trim($searchText);
    }

    public function Add()
    {
        $this->resetValidation();
        $this->resetExcept('customer');
        $this->customer = new Customer();
        $this->action = 2;
    }

    public function Edit(Customer $customer)
    {
        $this->resetValidation();
        $this->customer = $customer;
        $this->action = 3;
        $this->editing = true;
    }

    public function cancelEdit()
    {
        $this->resetValidation();
        $this->customer = new Customer();
        $this->action = 1;
        $this->editing = false;
    }

    function Store()
    {

        sleep(1);

        $this->validate($this->rules);

        //save
        $this->customer->save();

        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);
        $this->resetExcept('customer');
        $this->customer = new Customer();
    }



    function deliveryForm(Customer $customer)
    {
        $this->customerSelected = $customer;
        $this->dispatchBrowserEvent('modal-delivery');
    }




    function Destroy(Customer $customer)
    {

        //eliminar de tienda

        // obtener los deliveries asociadas al cliente
        $deliveries = $customer->deliveries;


        //eliminar las relaciones en la tabla pivote usando detach():
        $customer->deliveries()->detach();


        // eliminar los deliveries asociados al cliente de la tabla deliveries
        foreach ($deliveries as $delivery) {
            $delivery->delete();
        }



        //eliminar customer
        $customer->delete();

        //reset pagination
        $this->resetPage();

        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);
        $this->dispatchBrowserEvent('stop-loader');
    }


    //metodos para el delivery
    function saveDelivery()
    {

        $validatedData = $this->validate([
            'delivery.first_name' => 'required|max:45',
            'delivery.last_name' => 'nullable|max:45',
            'delivery.company' => 'nullable|max:60',
            'delivery.address1' => 'nullable|max:255',
            'delivery.address2' => 'nullable|max:255',
            'delivery.city' => 'nullable|max:50',
            'delivery.state' => 'nullable|max:50',
            'delivery.postcode' => 'nullable|max:10',
            'delivery.email' => 'nullable|email|max:55',
            'delivery.phone' => 'nullable|max:15',
            'delivery.country' => 'nullable|:max:40',
            'delivery.type' => 'required|in:billing,shipping'
        ]);

        // extraer el subarray 'delivery' del array validado
        $deliveryData = $validatedData['delivery'];

        // crear el modelo Delivery con los datos validados
        $delivery = Delivery::create($deliveryData);

        $this->customerSelected->deliveries()->attach($delivery->id);

        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);

        $this->customerSelected->load('deliveries');

        $this->delivery = [
            'type' => 'billing',
        ];
    }

    function editDelivery(Delivery $delivery)
    {
        //hacer esto se deja de tener una propiedad nested data por una instancia de Delivery
        //$this->delivery = $delivery;

        // clonar los datos del modelo a la nueva propiedad
        $editDeliveryData = $delivery->toArray();

        $this->delivery = $editDeliveryData;
    }

    function removeDelivery(Delivery $delivery)
    {

        // Eliminar la relación en la tabla pivot
        $this->customerSelected->deliveries()->detach($delivery->id);

        // Eliminar el delivery
        $delivery->delete();

        $this->customerSelected->load('deliveries');
        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);
    }


    function cancelEditDelivery()
    {
        $this->delivery = [
            'type' => 'billing',
        ];
    }


    function updateDelivery()
    {

        $validatedData = $this->validate([
            'delivery.first_name' => 'required|max:45',
            'delivery.last_name' => 'nullable|max:45',
            'delivery.company' => 'nullable|max:60',
            'delivery.address1' => 'nullable|max:255',
            'delivery.address2' => 'nullable|max:255',
            'delivery.city' => 'nullable|max:50',
            'delivery.state' => 'nullable|max:50',
            'delivery.postcode' => 'nullable|max:10',
            'delivery.email' => 'nullable|email|max:55',
            'delivery.phone' => 'nullable|max:15',
            'delivery.country' => 'nullable|:max:40',
            'delivery.type' => 'required|in:billing,shipping'
        ]);

        // xtraer el subarray 'delivery' del array validado
        $deliveryData = $validatedData['delivery'];

        //buscamos el delivery y lo actualizamos
        Delivery::find($this->delivery['id'])->update($deliveryData);

        $this->delivery = [
            'type' => 'billing',
        ];

        $this->dispatchBrowserEvent('noty', ['msg' => 'OPERACION CON EXITO']);

        $this->customerSelected->load('deliveries');
    }
}
