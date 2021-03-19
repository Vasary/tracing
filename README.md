# Tracing kit

[![Build Status](https://travis-ci.org/Vasary/tracing.svg?branch=master)](https://travis-ci.org/Vasary/tracing)
[![codecov](https://codecov.io/gh/Vasary/tracing/branch/master/graph/badge.svg?token=T7WGELDB6X)](https://codecov.io/gh/Vasary/tracing)

## Kit

### Request logger
* Sets trace id from the incoming request or generates new trace id
* Logging incoming request

### Response logger
* Adds trace id to the response headers
* Logs outgoing response body

### Application name logger processor
Adds to log message extra data with the application name

### Extra level name logger processor
Adds to log message extra data with an additional log level name

### Trace ID processor
Adds to log message extra data with trace id. All logs will have key extra.trace_id with trace id obtained from the incoming request or generated

### Extra parameters processor
Adds to log message extra data with any key/value pairs in the "extra" section
