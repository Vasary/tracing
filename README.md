# Tracing kit

[![Build Status](https://travis-ci.org/Vasary/tracing.svg?branch=master)](https://travis-ci.org/Vasary/tracing)
[![codecov](https://codecov.io/gh/Vasary/tracing/branch/master/graph/badge.svg?token=T7WGELDB6X)](https://codecov.io/gh/Vasary/tracing)

## Kit

### Request logger
* Set trace id from incoming request or generate new trace id.
* Log incoming request

### Response logger
* Add trace id to response
* Log outgoing response body

### Application name logger processor
Adds to log message extra data with application name. Needs for GELF.

### Extra level name logger processor
Adds to log message extra data with an additional log level name. Needs for GELF.

### Trace ID processor
Adds to log message extra data with trace id. All logs will have key extra.trace_id with trace id obtained from the incoming request or generated. (Requestlogger.php)
