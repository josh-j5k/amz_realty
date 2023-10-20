import { ref } from 'vue';

export function useListingFormValidator() {
    const formErrors = ref(
        {
            fileError: false,
            titleError: false,
            priceError: false,
            locationError: false,
            descriptionError: false,
            propertyStatusError: false,
            propertyTypeError: false
        }
    )
    const formValid = ref(
        {
            title: false,
            file: false,
            price: false,
            location: false,
            description: false,
            property_status: false,
            property_type: false
        }
    )
    function validation(title: string, description: string, property_type: string, price: string | number, property_status: string, location: string, total: number): boolean {
        if (title === '') {
            formErrors.value.titleError = true
        } else {
            formValid.value.title = true
        }
        if (description === '') {
            formErrors.value.descriptionError = true
        } else {
            formValid.value.description = true
        }
        if (property_type === '') {
            formErrors.value.propertyTypeError = true
        } else {
            formValid.value.property_type = true
        }
        if (location === '') {
            formErrors.value.locationError = true
        } else {
            formValid.value.location = true
        }
        if (property_status === '') {
            formErrors.value.propertyStatusError = true
        } else {
            formValid.value.property_status = true
        }
        if (price === '') {
            const intPrice = parseInt(price)
            if (isNaN(intPrice)) {
                formErrors.value.priceError = true
            } else {
                formValid.value.price = true
            }
        }
        if (total === 0) {
            formErrors.value.fileError = true
        } else {
            formValid.value.file = true
        }

        if (formValid.value.description === true && formValid.value.location === true && formValid.value.price === true && formValid.value.title === true && formValid.value.property_type === true && formValid.value.property_status === true && formValid.value.file === true) {
            return true
        } else {
            setTimeout(() => {
                formErrors.value.descriptionError = false
                formErrors.value.fileError = false
                formErrors.value.locationError = false
                formErrors.value.priceError = false
                formErrors.value.titleError = false
                formErrors.value.propertyTypeError = false
                formErrors.value.propertyStatusError = false
            }, 5000)
            return false
        }

    }
    return { formErrors, validation }
}