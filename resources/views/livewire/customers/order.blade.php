<div>
    <div class="col-lg-12 col-12">
        <div class="card">
            <h5 class="card-header">Assign Orders for {{ $id }}</h5>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div>
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Orders as $index => $order)
                                <tr class="col-12">
                                    <td>
                                        <label for="fp-date-time">Products</label>
                                        <select wire:model="Orders.{{ $index }}.id"
                                            class="form-control
                                          @error('Orders.{{ $index }}.id')
                                          border border-danger
                                          @enderror ">
                                            <option value=""> -- choose product_name -- </option>
                                            @foreach ($orderOne as $orderz)
                                                <option value="{{ $orderz->id }}">
                                                    {{ $orderz->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('Orders.{{ $index }}.id')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <label for="fp-date-time">Quantity</label>
                                        <input type="number" class="form-control"
                                            wire:model.prevent="Orders.{{ $index }}.quantity" />
                                        @error('Orders.{{ $index }}.quantity')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </td>

                                    <td>
                                        <a type="button" class="btn btn-outline-danger" href="#"
                                            wire:click="removeOrders({{ $index }})">
                                            <i data-feather="trash-2" class="mr-25"></i>
                                            <span>Delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12 m-2">
                            <button wire:click.prevent="addOrders" type="button" class="btn btn-outline-primary">
                                <i data-feather="user-plus" class="mr-25"></i>
                                <span>Add New Row</span>
                            </button>
                        </div>
                    </div>
                </div>

                @error('Targets.{{ $index }}.id')
                    <span class="error">{{ $message }}</span>
                @enderror
                @if ($countOrders)
                    <div class="m-2">
                        <button wire:click.prevent="submit()" type="submit"
                            class="btn btn-primary mr-1 data-submit">Submit</button>
                    </div>
                @else
                    <div class="m-2">
                        <button class="btn btn-outline-primary">DISABLED</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
