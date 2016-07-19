# Ask Red API

This is the API and administration module for Ask Red.

# Deployment

Deploy as you normally would. That includes using `git` to clone the repo, `composer` to install Laravel dependencies, etc. Google it if you must.

# API Usage

## Submitting a question

```
http://<url_to_api>/api/send/<asker>/<question>
```

Where:

* `<asker>` is a student number or a name (depends on your developer). This is in a `text` data type in the database so that it can easily be linked to a third-party database via a second query.
* `<question>` is a URL-encoded question. For instance, **What does CCSS stand for?** is turned into **What%20does%20CCSS%20stand%20for%3F**

On **success**, returns:

```
{
    "status":200,
    "hash":"tdphhs6w4sdo4Fg"
}
```

...where **hash** is a 16-character unique question identifier.

On **failure**, returns:

```
{
    "status":400
}
```

## Checking if a question has been answered
```
http://<url_to_api>/api/status/<hash>
```

Where:

* `<hash>` is your unique question identifier given back to you via the **Submitting a question** API. It is **randomly generated** per question.

On **success**, returns:

```
{
    "status":200,
    "answered":false
}
```

*answered* may be true or false depending on whether or not the question has been answered.

On **failure**, returns:

```
{
    "status":400,
    "message":"Question is not found."
}
```