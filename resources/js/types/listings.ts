export type Query = {
    location: string | null,
    status: string,
    price: {
        min: string,
        max: string
    },
    property_type: string[]
}

export type form = {
    location?: string,
    status?: string,
    price?: string,
    property_type: string,
}