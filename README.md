## Welcome to Kanye's finest quotes!

To get going, you need to have docker installed on your local system then go ahead and run

```./init_app.sh```

from a bash shell.

Once that has installed it's dependencies and spun up the docker containers, visit [localhost]http://localhost and enjoy a wide range of strange things Kanye has said over the years!

### Improvements to make

As it stands there are no unit tests currently in place, and this is definitely something I'd want to include going forward.

The API token validation is currently an extremely simple one, and would need to be fleshed out and hooked up to a full auth layer in the future. In a real world application, I would probably use something like Sanctum.

The current implimentation of caching is somewhat rudimentary, however I thinks it's okay for a first pass. I think we would need to establish a few more requirements in order to getting it to a production level layer. The random nature of the results from the kanye api does limit what we can cache as it stands.

More error handling is needed i.e. catching and showing issues with the upstream API service would be essential.