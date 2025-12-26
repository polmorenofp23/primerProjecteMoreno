class User{
    constructor(id, username, email, role, userType, firstName, lastName, phone, registeredAt){
        this.id = id;
        this.username = username;
        this.email = email;
        this.role = role;
        this.userType = userType;
        this.firstName = firstName;
        this.lastName = lastName;
        this.phone = phone;
        this.registeredAt = registeredAt;
    }
}

class ProductIngredient {
    constructor(productId, ingredientId, gramsPerPortion, portionPrice, isDefault) {
        this.productId = productId;
        this.ingredientId = ingredientId;
        this.gramsPerPortion = gramsPerPortion;
        this.portionPrice = portionPrice;
        this.isDefault = isDefault;
    }
}

class Product {
    constructor(id, name, description, dishType, price, imgDir, available, createdAt, updatedAt, productIngredients = undefined) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.dishType = dishType;
        this.price = price;
        this.imgDir = imgDir;
        this.available = available;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;
        if (productIngredients === undefined) {
            this.productIngredients = [];
        } else {
            this.productIngredients = productIngredients.map(item => {
                if (item instanceof ProductIngredient) return item;
                throw new TypeError('Each productIngredient must be an instance of ProductIngredient or a convertible object');
            });
        }
    }
}

class Ingredient {
    constructor(id, name, category, description, pricePer100g, kcalPer100g, hasDoneness, country, available, createdAt, updatedAt) {
        this.id = id;
        this.name = name;
        this.category = category;
        this.description = description;
        this.pricePer100g = pricePer100g;
        this.kcalPer100g = kcalPer100g;
        this.hasDoneness = hasDoneness;
        this.country = country;
        this.available = available;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;
    }
}

class Orders {
    constructor(id, userId, discountId, totalAmount, discountAmount, tableId, orderStatus, paymentStatus, createdAt, updatedAt) {
        this.id = id;
        this.userId = userId;
        this.discountId = discountId;
        this.totalAmount = totalAmount;
        this.discountAmount = discountAmount;
        this.tableId = tableId;
        this.orderStatus = orderStatus;
        this.paymentStatus = paymentStatus;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;
    }
}

class OrderLine {
    constructor(id, orderId, productId, quantity, unitPrice) {
        this.id = id;
        this.orderId = orderId;
        this.productId = productId;
        this.quantity = quantity;
        this.unitPrice = unitPrice;
    }
}

class OrderLineIngredient {
    constructor(lineId, ingredientId, numPortions, ingredientPrice, grams, kcalComponent, proteinG, carbsG, fatG, origin, doneness) {
        this.lineId = lineId;
        this.ingredientId = ingredientId;
        this.numPortions = numPortions;
        this.ingredientPrice = ingredientPrice;
        this.grams = grams;
        this.kcalComponent = kcalComponent;
        this.proteinG = proteinG;
        this.carbsG = carbsG;
        this.fatG = fatG;
        this.origin = origin;
        this.doneness = doneness;
    }
}

class Discount {
    constructor(id, name, description, percentage, status, type, discountCode, startDatetime, endDatetime, numReuses, imgDir, userTypeId) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.percentage = percentage;
        this.status = status;
        this.type = type;
        this.discountCode = discountCode;
        this.startDatetime = startDatetime;
        this.endDatetime = endDatetime;
        this.numReuses = numReuses;
        this.imgDir = imgDir;
        this.userTypeId = userTypeId;
    }
}

class HttpResponse {
    constructor(code, name, description, level, message) {
        this.code = code;
        this.name = name;
        this.description = description;
        this.level = level;
        this.message = message;
    }
}

class UserType {
    constructor(id, name, description) {
        this.id = id;
        this.name = name;
        this.description = description;
    }
}

export {
    User,
    Product,
    Ingredient,
    ProductIngredient,
    Orders,
    OrderLine,
    OrderLineIngredient,
    Discount,
    HttpResponse,
    UserType
};