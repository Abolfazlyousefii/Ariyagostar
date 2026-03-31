<script id="product-template" type="template/html">

    <%
        let priceItem = product.prices.find(item => (item.id == $('#add-product-to-order').val().replace('\\-', 'p-').replace("p-", "") || item.id == $('#add-product-to-order').val().replace('\\-', 'P-').replace("P-", "")));

        if(priceItem == undefined) {
            priceItem = product.prices[0]
        }
    %>

    <div class="row order-single-product">
        <div class="col-md-1" style="padding-top: 33px;">
            <img class="w-100" src="<%= product.image %>" alt="<%= product.title %>">
        </div>
        <div class="col-md-3 mt-1">
            <div class="mb-1">
                <strong><%= product.title %></strong>
            </div>
            <% if (priceItem.attributes.length) { %>
                <div class="mb-1">
                    <select class="form-control price-select">
                        <% product.prices.forEach(function(price){ %>

                            <option value="<%= price.id %>" data-price="<%= JSON.stringify(price) %>" <% if (priceItem.id == price.id) { %> selected <% } %>>
                                <% let attcount = 0 %>
                                <% price.attributes.forEach(function(attribute){ %>
                                    <%= attribute.group.name %> : <%= attribute.name %>
                                    <% if (++attcount < price.attributes.length) { %>
                                        ,
                                    <% } %>
                                <% }); %>
                            </option>
                        <% }); %>
                    </select>
                </div>
            <% } %>
            <strong class="text-success"><span class="sale-price"><%= number_format(priceItem.price) %></span> تومان</strong>

            <del class="text-danger regular-price-container <% if (!priceItem.regular_price) { %> d-none <% } %>"><span class="regular-price"><%= number_format(priceItem.regular_price) %></span> تومان</del>

            <input class="selected-price" name="products[<%= productsCount %>][price_id]" type="hidden" value="<%= priceItem.id %>">
            <input name="products[<%= productsCount %>][id]" type="hidden" value="<%= product.id %>">
        </div>
        <div class="col-md-2" style="padding-top: 18px;">
            <div class="form-group">
                <label for="">قیمت</label>
                <input type="number" name="products[<%= productsCount %>][price]" class="form-control product-price amount-input ltr" value="<%= priceItem.regular_price %>">
            </div>
        </div>
        <div class="col-md-2" style="padding-top: 18px;">
            <div class="form-group">
                <label for="">تخفیف (تومان)</label>
                <input type="number" name="products[<%= productsCount %>][discount]" class="form-control ltr product-discount amount-input" value="<%= priceItem.regular_price - priceItem.price %>">
            </div>
        </div>
        <div class="col-md-2" style="padding-top: 18px;">
            <div class="form-group">
                <label for="">تعداد</label>
                <input type="number" name="products[<%= productsCount %>][quantity]" class="form-control product-quantity ltr" max="<%= priceItem.stock %>" min="1" value="1">
            </div>
        </div>
        <div class="col-md-2" style="padding-top: 38px;">
            <button type="button" class="btn btn-outline-danger delete-product-btn" style="margin-top: 8px;"><i class="feather icon-trash"></i></button>
        </div>
        <hr class="w-100">
    </div>
</script>
