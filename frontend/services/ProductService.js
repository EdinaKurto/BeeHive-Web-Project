
var ProductService = {
  init: function () {
    FormValidation.validate(
      "#addItemForm",
      {
        product_name: "required",
        category_id: "required",
        stock_quantity: {
          required: true,
          digits: true,
          min: 1
        },
        price: {
          required: true,
          number: true,
          min: 0.01
        }
      },
      {
        product_name: "Please enter the product name.",
        category_id: "Please select a category.",
        stock_quantity: {
          required: "Please enter the quantity.",
          digits: "Quantity must be a whole number.",
          min: "Quantity must be at least 1."
        },
        price: {
          required: "Please enter the price.",
          number: "Price must be a valid number.",
          min: "Price must be at least 0.01."
        }
      },
      ProductService.addProduct
    );
  },

  addProduct: function (data) {
    Utils.block_ui("#addItemForm");

    RestClient.post(
      "products",
      data,
      function (response) {
        const productId = response.product_id;

        const filesInput = document.getElementById("formFileMultiple");
        if (filesInput && filesInput.files.length > 0) {
          let uploaded = 0;
          for (let i = 0; i < filesInput.files.length; i++) {
            const formData = new FormData();
            formData.append("product_image", filesInput.files[i]);

            RestClient.uploadFile(
              `products/upload_image/${productId}`,
              formData,
              function () {
                uploaded++;
                if (uploaded === filesInput.files.length) {
                  toastr.success("Product and all images uploaded.");
                  $("#addItemModal").modal("hide");
                  ProductService.getAllProducts();
                  Utils.unblock_ui("#addItemForm");
                }
              },
              function () {
                toastr.error("One or more images failed to upload.");
                Utils.unblock_ui("#addItemForm");
              }
            );
          }
        } else {
          toastr.success("Product added without images.");
          $("#addItemModal").modal("hide");
          ProductService.getAllProducts();
          Utils.unblock_ui("#addItemForm");
        }
      },
      function () {
        toastr.error("Failed to add product.");
        Utils.unblock_ui("#addItemForm");
      }
    );
  },

  getAllProducts: function () {
    RestClient.get("products", function (data) {
      Utils.datatable("itemsTable", [
        { data: "product_name", title: "Name" },
        { data: "category_name", title: "Category" },
        { data: "stock_quantity", title: "Stock" },
        { data: "price", title: "Price" },
        { data: "description", title: "Description" },
        {
          title: "Actions",
          render: function (data, type, row) {
            const rowStr = encodeURIComponent(JSON.stringify(row));
            return `<div class="d-flex justify-content-center gap-2 mt-3">
              <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editItemModal" onclick="ProductService.openEditModal('${row.product_id}')">Edit</button>
              <button class="btn btn-danger" onclick="ProductService.openConfirmationDialog(decodeURIComponent('${rowStr}'))">Delete</button>
            </div>`;
          }
        }
      ], data, 10);
    }, function () {
      console.error("Failed to fetch products.");
    });
  },

  getProductById: function (id) {
    RestClient.get("products/" + id, function (data) {
      localStorage.setItem("selected_product", JSON.stringify(data));
      $('input[name="product_name"]').val(data.product_name);
      $('input[name="stock_quantity"]').val(data.stock_quantity);
      $('input[name="price"]').val(data.price);
      $('input[name="description"]').val(data.description);
      $('select[name="category_id"]').val(data.category_id).trigger("change");
      $.unblockUI();
    }, function () {
      console.error("Failed to fetch product.");
    });
  },

  openEditModal: function (id) {
    Utils.block_ui("#editItemModal");
    ProductService.loadCategories();
    $('#editItemModal').modal('show');
    ProductService.getProductById(id);
    Utils.unblock_ui("#editItemModal");
  },

  loadCategories: function () {
    RestClient.get("categories", function (categories) {
      const categorySelects = $('select[name="category_id"]');
      categorySelects.empty();

      categories.forEach(function (category) {
        categorySelects.append(
          $('<option>', {
            value: category.category_id,
            text: category.category_name
          })
        );
      });
    }, function () {
      console.error("Failed to load categories.");
    });
  }
};
