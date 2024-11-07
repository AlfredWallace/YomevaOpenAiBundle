Usage
=====

### The entry point of the bundle is the `Service/OpenAiClient`

You should inject it wherever you need, and use the functions that match the OpenAI APIs 
to make calls to them, thanks to the `api_key` you provided in the configuration.
Some functions can or must be provided with a payload, meaning the corresponding OpenAI API endpoint 
requires a body to be used. 

### Payload builders
The easiest way to build a correct payload is to use a builder for the corresponding function. 
Builders can be found in `src/Builder`. 

### PayloadInterfaces
If you don't want to use a builder, you can build the payload by using the models in `src/Model`

### Arrays
You can also build the payload in your own way and pass an array to the function, it will use that
as a body and send it directly to the OpenAI APIs without any verification.