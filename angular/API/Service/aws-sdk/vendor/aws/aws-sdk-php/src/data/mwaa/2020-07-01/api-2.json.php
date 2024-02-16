<?php
// This file was auto-generated from sdk-root/src/data/mwaa/2020-07-01/api-2.json
return [ 'version' => '2.0', 'metadata' => [ 'apiVersion' => '2020-07-01', 'endpointPrefix' => 'airflow', 'jsonVersion' => '1.1', 'protocol' => 'rest-json', 'serviceFullName' => 'AmazonMWAA', 'serviceId' => 'MWAA', 'signatureVersion' => 'v4', 'signingName' => 'airflow', 'uid' => 'mwaa-2020-07-01', ], 'operations' => [ 'CreateCliToken' => [ 'name' => 'CreateCliToken', 'http' => [ 'method' => 'POST', 'requestUri' => '/clitoken/{Name}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'CreateCliTokenRequest', ], 'output' => [ 'shape' => 'CreateCliTokenResponse', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], ], 'endpoint' => [ 'hostPrefix' => 'env.', ], ], 'CreateEnvironment' => [ 'name' => 'CreateEnvironment', 'http' => [ 'method' => 'PUT', 'requestUri' => '/environments/{Name}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'CreateEnvironmentInput', ], 'output' => [ 'shape' => 'CreateEnvironmentOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'endpoint' => [ 'hostPrefix' => 'api.', ], 'idempotent' => true, ], 'CreateWebLoginToken' => [ 'name' => 'CreateWebLoginToken', 'http' => [ 'method' => 'POST', 'requestUri' => '/webtoken/{Name}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'CreateWebLoginTokenRequest', ], 'output' => [ 'shape' => 'CreateWebLoginTokenResponse', ], 'errors' => [ [ 'shape' => 'AccessDeniedException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'endpoint' => [ 'hostPrefix' => 'env.', ], 'idempotent' => true, ], 'DeleteEnvironment' => [ 'name' => 'DeleteEnvironment', 'http' => [ 'method' => 'DELETE', 'requestUri' => '/environments/{Name}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'DeleteEnvironmentInput', ], 'output' => [ 'shape' => 'DeleteEnvironmentOutput', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'endpoint' => [ 'hostPrefix' => 'api.', ], 'idempotent' => true, ], 'GetEnvironment' => [ 'name' => 'GetEnvironment', 'http' => [ 'method' => 'GET', 'requestUri' => '/environments/{Name}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'GetEnvironmentInput', ], 'output' => [ 'shape' => 'GetEnvironmentOutput', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'endpoint' => [ 'hostPrefix' => 'api.', ], ], 'ListEnvironments' => [ 'name' => 'ListEnvironments', 'http' => [ 'method' => 'GET', 'requestUri' => '/environments', 'responseCode' => 200, ], 'input' => [ 'shape' => 'ListEnvironmentsInput', ], 'output' => [ 'shape' => 'ListEnvironmentsOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'endpoint' => [ 'hostPrefix' => 'api.', ], ], 'ListTagsForResource' => [ 'name' => 'ListTagsForResource', 'http' => [ 'method' => 'GET', 'requestUri' => '/tags/{ResourceArn}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'ListTagsForResourceInput', ], 'output' => [ 'shape' => 'ListTagsForResourceOutput', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'endpoint' => [ 'hostPrefix' => 'api.', ], ], 'PublishMetrics' => [ 'name' => 'PublishMetrics', 'http' => [ 'method' => 'POST', 'requestUri' => '/metrics/environments/{EnvironmentName}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'PublishMetricsInput', ], 'output' => [ 'shape' => 'PublishMetricsOutput', ], 'errors' => [ [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'deprecated' => true, 'deprecatedMessage' => 'This API is for internal use and not meant for public use, and is no longer available.', 'endpoint' => [ 'hostPrefix' => 'ops.', ], ], 'TagResource' => [ 'name' => 'TagResource', 'http' => [ 'method' => 'POST', 'requestUri' => '/tags/{ResourceArn}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'TagResourceInput', ], 'output' => [ 'shape' => 'TagResourceOutput', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'endpoint' => [ 'hostPrefix' => 'api.', ], ], 'UntagResource' => [ 'name' => 'UntagResource', 'http' => [ 'method' => 'DELETE', 'requestUri' => '/tags/{ResourceArn}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'UntagResourceInput', ], 'output' => [ 'shape' => 'UntagResourceOutput', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'endpoint' => [ 'hostPrefix' => 'api.', ], 'idempotent' => true, ], 'UpdateEnvironment' => [ 'name' => 'UpdateEnvironment', 'http' => [ 'method' => 'PATCH', 'requestUri' => '/environments/{Name}', 'responseCode' => 200, ], 'input' => [ 'shape' => 'UpdateEnvironmentInput', ], 'output' => [ 'shape' => 'UpdateEnvironmentOutput', ], 'errors' => [ [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'ValidationException', ], [ 'shape' => 'InternalServerException', ], ], 'endpoint' => [ 'hostPrefix' => 'api.', ], ], ], 'shapes' => [ 'AccessDeniedException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'String', ], ], 'error' => [ 'httpStatusCode' => 403, 'senderFault' => true, ], 'exception' => true, ], 'AirflowConfigurationOptions' => [ 'type' => 'map', 'key' => [ 'shape' => 'ConfigKey', ], 'value' => [ 'shape' => 'ConfigValue', ], 'sensitive' => true, ], 'AirflowVersion' => [ 'type' => 'string', 'max' => 32, 'min' => 1, 'pattern' => '^[0-9a-z.]+$', ], 'CloudWatchLogGroupArn' => [ 'type' => 'string', 'max' => 1224, 'min' => 1, 'pattern' => '^arn:aws(-[a-z]+)?:logs:[a-z0-9\\-]+:\\d{12}:log-group:\\w+', ], 'ConfigKey' => [ 'type' => 'string', 'max' => 64, 'min' => 1, 'pattern' => '^[a-z]+([a-z0-9._]*[a-z0-9_]+)?$', ], 'ConfigValue' => [ 'type' => 'string', 'max' => 65536, 'min' => 1, 'pattern' => '^[ -~]+$', 'sensitive' => true, ], 'CreateCliTokenRequest' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'EnvironmentName', 'location' => 'uri', 'locationName' => 'Name', ], ], ], 'CreateCliTokenResponse' => [ 'type' => 'structure', 'members' => [ 'CliToken' => [ 'shape' => 'Token', ], 'WebServerHostname' => [ 'shape' => 'Hostname', ], ], ], 'CreateEnvironmentInput' => [ 'type' => 'structure', 'required' => [ 'DagS3Path', 'ExecutionRoleArn', 'Name', 'NetworkConfiguration', 'SourceBucketArn', ], 'members' => [ 'AirflowConfigurationOptions' => [ 'shape' => 'AirflowConfigurationOptions', ], 'AirflowVersion' => [ 'shape' => 'AirflowVersion', ], 'DagS3Path' => [ 'shape' => 'RelativePath', ], 'EnvironmentClass' => [ 'shape' => 'EnvironmentClass', ], 'ExecutionRoleArn' => [ 'shape' => 'IamRoleArn', ], 'KmsKey' => [ 'shape' => 'KmsKey', ], 'LoggingConfiguration' => [ 'shape' => 'LoggingConfigurationInput', ], 'MaxWorkers' => [ 'shape' => 'MaxWorkers', ], 'MinWorkers' => [ 'shape' => 'MinWorkers', ], 'Name' => [ 'shape' => 'EnvironmentName', 'location' => 'uri', 'locationName' => 'Name', ], 'NetworkConfiguration' => [ 'shape' => 'NetworkConfiguration', ], 'PluginsS3ObjectVersion' => [ 'shape' => 'S3ObjectVersion', ], 'PluginsS3Path' => [ 'shape' => 'RelativePath', ], 'RequirementsS3ObjectVersion' => [ 'shape' => 'S3ObjectVersion', ], 'RequirementsS3Path' => [ 'shape' => 'RelativePath', ], 'Schedulers' => [ 'shape' => 'Schedulers', ], 'SourceBucketArn' => [ 'shape' => 'S3BucketArn', ], 'StartupScriptS3ObjectVersion' => [ 'shape' => 'S3ObjectVersion', ], 'StartupScriptS3Path' => [ 'shape' => 'RelativePath', ], 'Tags' => [ 'shape' => 'TagMap', ], 'WebserverAccessMode' => [ 'shape' => 'WebserverAccessMode', ], 'WeeklyMaintenanceWindowStart' => [ 'shape' => 'WeeklyMaintenanceWindowStart', ], ], ], 'CreateEnvironmentOutput' => [ 'type' => 'structure', 'members' => [ 'Arn' => [ 'shape' => 'EnvironmentArn', ], ], ], 'CreateWebLoginTokenRequest' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'EnvironmentName', 'location' => 'uri', 'locationName' => 'Name', ], ], ], 'CreateWebLoginTokenResponse' => [ 'type' => 'structure', 'members' => [ 'WebServerHostname' => [ 'shape' => 'Hostname', ], 'WebToken' => [ 'shape' => 'Token', ], ], ], 'CreatedAt' => [ 'type' => 'timestamp', ], 'DeleteEnvironmentInput' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'EnvironmentName', 'location' => 'uri', 'locationName' => 'Name', ], ], ], 'DeleteEnvironmentOutput' => [ 'type' => 'structure', 'members' => [], ], 'Dimension' => [ 'type' => 'structure', 'required' => [ 'Name', 'Value', ], 'members' => [ 'Name' => [ 'shape' => 'String', ], 'Value' => [ 'shape' => 'String', ], ], 'deprecated' => true, 'deprecatedMessage' => 'This type is for internal use and not meant for public use. Data set for this type will be ignored.', ], 'Dimensions' => [ 'type' => 'list', 'member' => [ 'shape' => 'Dimension', ], 'deprecated' => true, 'deprecatedMessage' => 'This type is for internal use and not meant for public use. Data set for this type will be ignored.', ], 'Double' => [ 'type' => 'double', 'box' => true, ], 'Environment' => [ 'type' => 'structure', 'members' => [ 'AirflowConfigurationOptions' => [ 'shape' => 'AirflowConfigurationOptions', ], 'AirflowVersion' => [ 'shape' => 'AirflowVersion', ], 'Arn' => [ 'shape' => 'EnvironmentArn', ], 'CreatedAt' => [ 'shape' => 'CreatedAt', ], 'DagS3Path' => [ 'shape' => 'RelativePath', ], 'EnvironmentClass' => [ 'shape' => 'EnvironmentClass', ], 'ExecutionRoleArn' => [ 'shape' => 'IamRoleArn', ], 'KmsKey' => [ 'shape' => 'KmsKey', ], 'LastUpdate' => [ 'shape' => 'LastUpdate', ], 'LoggingConfiguration' => [ 'shape' => 'LoggingConfiguration', ], 'MaxWorkers' => [ 'shape' => 'MaxWorkers', ], 'MinWorkers' => [ 'shape' => 'MinWorkers', ], 'Name' => [ 'shape' => 'EnvironmentName', ], 'NetworkConfiguration' => [ 'shape' => 'NetworkConfiguration', ], 'PluginsS3ObjectVersion' => [ 'shape' => 'S3ObjectVersion', ], 'PluginsS3Path' => [ 'shape' => 'RelativePath', ], 'RequirementsS3ObjectVersion' => [ 'shape' => 'S3ObjectVersion', ], 'RequirementsS3Path' => [ 'shape' => 'RelativePath', ], 'Schedulers' => [ 'shape' => 'Schedulers', ], 'ServiceRoleArn' => [ 'shape' => 'IamRoleArn', ], 'SourceBucketArn' => [ 'shape' => 'S3BucketArn', ], 'StartupScriptS3ObjectVersion' => [ 'shape' => 'String', ], 'StartupScriptS3Path' => [ 'shape' => 'String', ], 'Status' => [ 'shape' => 'EnvironmentStatus', ], 'Tags' => [ 'shape' => 'TagMap', ], 'WebserverAccessMode' => [ 'shape' => 'WebserverAccessMode', ], 'WebserverUrl' => [ 'shape' => 'WebserverUrl', ], 'WeeklyMaintenanceWindowStart' => [ 'shape' => 'WeeklyMaintenanceWindowStart', ], ], ], 'EnvironmentArn' => [ 'type' => 'string', 'max' => 1224, 'min' => 1, 'pattern' => '^arn:aws(-[a-z]+)?:airflow:[a-z0-9\\-]+:\\d{12}:environment/\\w+', ], 'EnvironmentClass' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, ], 'EnvironmentList' => [ 'type' => 'list', 'member' => [ 'shape' => 'EnvironmentName', ], ], 'EnvironmentName' => [ 'type' => 'string', 'max' => 80, 'min' => 1, 'pattern' => '^[a-zA-Z][0-9a-zA-Z-_]*$', ], 'EnvironmentStatus' => [ 'type' => 'string', 'enum' => [ 'CREATING', 'CREATE_FAILED', 'AVAILABLE', 'UPDATING', 'DELETING', 'DELETED', 'UNAVAILABLE', 'UPDATE_FAILED', 'ROLLING_BACK', 'CREATING_SNAPSHOT', ], ], 'ErrorCode' => [ 'type' => 'string', ], 'ErrorMessage' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, 'pattern' => '^.+$', ], 'GetEnvironmentInput' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'Name' => [ 'shape' => 'EnvironmentName', 'location' => 'uri', 'locationName' => 'Name', ], ], ], 'GetEnvironmentOutput' => [ 'type' => 'structure', 'members' => [ 'Environment' => [ 'shape' => 'Environment', ], ], ], 'Hostname' => [ 'type' => 'string', 'max' => 255, 'min' => 1, 'pattern' => '^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\\-]*[a-zA-Z0-9])\\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\\-]*[A-Za-z0-9])$', ], 'IamRoleArn' => [ 'type' => 'string', 'max' => 1224, 'min' => 1, 'pattern' => '^arn:aws(-[a-z]+)?:iam::\\d{12}:role/?[a-zA-Z_0-9+=,.@\\-_/]+$', ], 'Integer' => [ 'type' => 'integer', 'box' => true, ], 'InternalServerException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'String', ], ], 'error' => [ 'httpStatusCode' => 500, ], 'exception' => true, 'fault' => true, ], 'KmsKey' => [ 'type' => 'string', 'max' => 1224, 'min' => 1, 'pattern' => '^(((arn:aws(-[a-z]+)?:kms:[a-z]{2}-[a-z]+-\\d:\\d+:)?key\\/)?[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}|(arn:aws(-[a-z]+)?:kms:[a-z]{2}-[a-z]+-\\d:\\d+:)?alias/.+)$', ], 'LastUpdate' => [ 'type' => 'structure', 'members' => [ 'CreatedAt' => [ 'shape' => 'UpdateCreatedAt', ], 'Error' => [ 'shape' => 'UpdateError', ], 'Source' => [ 'shape' => 'UpdateSource', ], 'Status' => [ 'shape' => 'UpdateStatus', ], ], ], 'ListEnvironmentsInput' => [ 'type' => 'structure', 'members' => [ 'MaxResults' => [ 'shape' => 'ListEnvironmentsInputMaxResultsInteger', 'location' => 'querystring', 'locationName' => 'MaxResults', ], 'NextToken' => [ 'shape' => 'NextToken', 'location' => 'querystring', 'locationName' => 'NextToken', ], ], ], 'ListEnvironmentsInputMaxResultsInteger' => [ 'type' => 'integer', 'box' => true, 'max' => 25, 'min' => 1, ], 'ListEnvironmentsOutput' => [ 'type' => 'structure', 'required' => [ 'Environments', ], 'members' => [ 'Environments' => [ 'shape' => 'EnvironmentList', ], 'NextToken' => [ 'shape' => 'NextToken', ], ], ], 'ListTagsForResourceInput' => [ 'type' => 'structure', 'required' => [ 'ResourceArn', ], 'members' => [ 'ResourceArn' => [ 'shape' => 'EnvironmentArn', 'location' => 'uri', 'locationName' => 'ResourceArn', ], ], ], 'ListTagsForResourceOutput' => [ 'type' => 'structure', 'members' => [ 'Tags' => [ 'shape' => 'TagMap', ], ], ], 'LoggingConfiguration' => [ 'type' => 'structure', 'members' => [ 'DagProcessingLogs' => [ 'shape' => 'ModuleLoggingConfiguration', ], 'SchedulerLogs' => [ 'shape' => 'ModuleLoggingConfiguration', ], 'TaskLogs' => [ 'shape' => 'ModuleLoggingConfiguration', ], 'WebserverLogs' => [ 'shape' => 'ModuleLoggingConfiguration', ], 'WorkerLogs' => [ 'shape' => 'ModuleLoggingConfiguration', ], ], ], 'LoggingConfigurationInput' => [ 'type' => 'structure', 'members' => [ 'DagProcessingLogs' => [ 'shape' => 'ModuleLoggingConfigurationInput', ], 'SchedulerLogs' => [ 'shape' => 'ModuleLoggingConfigurationInput', ], 'TaskLogs' => [ 'shape' => 'ModuleLoggingConfigurationInput', ], 'WebserverLogs' => [ 'shape' => 'ModuleLoggingConfigurationInput', ], 'WorkerLogs' => [ 'shape' => 'ModuleLoggingConfigurationInput', ], ], ], 'LoggingEnabled' => [ 'type' => 'boolean', 'box' => true, ], 'LoggingLevel' => [ 'type' => 'string', 'enum' => [ 'CRITICAL', 'ERROR', 'WARNING', 'INFO', 'DEBUG', ], ], 'MaxWorkers' => [ 'type' => 'integer', 'box' => true, 'min' => 1, ], 'MetricData' => [ 'type' => 'list', 'member' => [ 'shape' => 'MetricDatum', ], 'deprecated' => true, 'deprecatedMessage' => 'This type is for internal use and not meant for public use. Data set for this type will be ignored.', ], 'MetricDatum' => [ 'type' => 'structure', 'required' => [ 'MetricName', 'Timestamp', ], 'members' => [ 'Dimensions' => [ 'shape' => 'Dimensions', ], 'MetricName' => [ 'shape' => 'String', ], 'StatisticValues' => [ 'shape' => 'StatisticSet', ], 'Timestamp' => [ 'shape' => 'Timestamp', ], 'Unit' => [ 'shape' => 'Unit', ], 'Value' => [ 'shape' => 'Double', ], ], 'deprecated' => true, 'deprecatedMessage' => 'This type is for internal use and not meant for public use. Data set for this type will be ignored.', ], 'MinWorkers' => [ 'type' => 'integer', 'box' => true, 'min' => 1, ], 'ModuleLoggingConfiguration' => [ 'type' => 'structure', 'members' => [ 'CloudWatchLogGroupArn' => [ 'shape' => 'CloudWatchLogGroupArn', ], 'Enabled' => [ 'shape' => 'LoggingEnabled', ], 'LogLevel' => [ 'shape' => 'LoggingLevel', ], ], ], 'ModuleLoggingConfigurationInput' => [ 'type' => 'structure', 'required' => [ 'Enabled', 'LogLevel', ], 'members' => [ 'Enabled' => [ 'shape' => 'LoggingEnabled', ], 'LogLevel' => [ 'shape' => 'LoggingLevel', ], ], ], 'NetworkConfiguration' => [ 'type' => 'structure', 'members' => [ 'SecurityGroupIds' => [ 'shape' => 'SecurityGroupList', ], 'SubnetIds' => [ 'shape' => 'SubnetList', ], ], ], 'NextToken' => [ 'type' => 'string', 'max' => 2048, 'min' => 0, ], 'PublishMetricsInput' => [ 'type' => 'structure', 'required' => [ 'EnvironmentName', 'MetricData', ], 'members' => [ 'EnvironmentName' => [ 'shape' => 'EnvironmentName', 'location' => 'uri', 'locationName' => 'EnvironmentName', ], 'MetricData' => [ 'shape' => 'MetricData', ], ], 'deprecated' => true, 'deprecatedMessage' => 'This type is for internal use and not meant for public use. Data set for this type will be ignored.', ], 'PublishMetricsOutput' => [ 'type' => 'structure', 'members' => [], 'deprecated' => true, 'deprecatedMessage' => 'This type is for internal use and not meant for public use. Data set for this type will be ignored.', ], 'RelativePath' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, 'pattern' => '.*', ], 'ResourceNotFoundException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'String', ], ], 'error' => [ 'httpStatusCode' => 404, 'senderFault' => true, ], 'exception' => true, ], 'S3BucketArn' => [ 'type' => 'string', 'max' => 1224, 'min' => 1, 'pattern' => '^arn:aws(-[a-z]+)?:s3:::[a-z0-9.\\-]+$', ], 'S3ObjectVersion' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, ], 'Schedulers' => [ 'type' => 'integer', 'box' => true, 'max' => 5, ], 'SecurityGroupId' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, 'pattern' => '^sg-[a-zA-Z0-9\\-._]+$', ], 'SecurityGroupList' => [ 'type' => 'list', 'member' => [ 'shape' => 'SecurityGroupId', ], 'max' => 5, 'min' => 1, ], 'StatisticSet' => [ 'type' => 'structure', 'members' => [ 'Maximum' => [ 'shape' => 'Double', ], 'Minimum' => [ 'shape' => 'Double', ], 'SampleCount' => [ 'shape' => 'Integer', ], 'Sum' => [ 'shape' => 'Double', ], ], 'deprecated' => true, 'deprecatedMessage' => 'This type is for internal use and not meant for public use. Data set for this type will be ignored.', ], 'String' => [ 'type' => 'string', ], 'SubnetId' => [ 'type' => 'string', 'max' => 1024, 'min' => 1, 'pattern' => '^subnet-[a-zA-Z0-9\\-._]+$', ], 'SubnetList' => [ 'type' => 'list', 'member' => [ 'shape' => 'SubnetId', ], 'max' => 2, 'min' => 2, ], 'TagKey' => [ 'type' => 'string', 'max' => 128, 'min' => 1, 'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$', ], 'TagKeyList' => [ 'type' => 'list', 'member' => [ 'shape' => 'TagKey', ], 'max' => 50, 'min' => 0, ], 'TagMap' => [ 'type' => 'map', 'key' => [ 'shape' => 'TagKey', ], 'value' => [ 'shape' => 'TagValue', ], 'max' => 50, 'min' => 1, ], 'TagResourceInput' => [ 'type' => 'structure', 'required' => [ 'ResourceArn', 'Tags', ], 'members' => [ 'ResourceArn' => [ 'shape' => 'EnvironmentArn', 'location' => 'uri', 'locationName' => 'ResourceArn', ], 'Tags' => [ 'shape' => 'TagMap', ], ], ], 'TagResourceOutput' => [ 'type' => 'structure', 'members' => [], ], 'TagValue' => [ 'type' => 'string', 'max' => 256, 'min' => 1, 'pattern' => '^([\\p{L}\\p{Z}\\p{N}_.:/=+\\-@]*)$', ], 'Timestamp' => [ 'type' => 'timestamp', ], 'Token' => [ 'type' => 'string', 'sensitive' => true, ], 'Unit' => [ 'type' => 'string', 'enum' => [ 'Seconds', 'Microseconds', 'Milliseconds', 'Bytes', 'Kilobytes', 'Megabytes', 'Gigabytes', 'Terabytes', 'Bits', 'Kilobits', 'Megabits', 'Gigabits', 'Terabits', 'Percent', 'Count', 'Bytes/Second', 'Kilobytes/Second', 'Megabytes/Second', 'Gigabytes/Second', 'Terabytes/Second', 'Bits/Second', 'Kilobits/Second', 'Megabits/Second', 'Gigabits/Second', 'Terabits/Second', 'Count/Second', 'None', ], ], 'UntagResourceInput' => [ 'type' => 'structure', 'required' => [ 'ResourceArn', 'tagKeys', ], 'members' => [ 'ResourceArn' => [ 'shape' => 'EnvironmentArn', 'location' => 'uri', 'locationName' => 'ResourceArn', ], 'tagKeys' => [ 'shape' => 'TagKeyList', 'location' => 'querystring', 'locationName' => 'tagKeys', ], ], ], 'UntagResourceOutput' => [ 'type' => 'structure', 'members' => [], ], 'UpdateCreatedAt' => [ 'type' => 'timestamp', ], 'UpdateEnvironmentInput' => [ 'type' => 'structure', 'required' => [ 'Name', ], 'members' => [ 'AirflowConfigurationOptions' => [ 'shape' => 'AirflowConfigurationOptions', ], 'AirflowVersion' => [ 'shape' => 'AirflowVersion', ], 'DagS3Path' => [ 'shape' => 'RelativePath', ], 'EnvironmentClass' => [ 'shape' => 'EnvironmentClass', ], 'ExecutionRoleArn' => [ 'shape' => 'IamRoleArn', ], 'LoggingConfiguration' => [ 'shape' => 'LoggingConfigurationInput', ], 'MaxWorkers' => [ 'shape' => 'MaxWorkers', ], 'MinWorkers' => [ 'shape' => 'MinWorkers', ], 'Name' => [ 'shape' => 'EnvironmentName', 'location' => 'uri', 'locationName' => 'Name', ], 'NetworkConfiguration' => [ 'shape' => 'UpdateNetworkConfigurationInput', ], 'PluginsS3ObjectVersion' => [ 'shape' => 'S3ObjectVersion', ], 'PluginsS3Path' => [ 'shape' => 'RelativePath', ], 'RequirementsS3ObjectVersion' => [ 'shape' => 'S3ObjectVersion', ], 'RequirementsS3Path' => [ 'shape' => 'RelativePath', ], 'Schedulers' => [ 'shape' => 'Schedulers', ], 'SourceBucketArn' => [ 'shape' => 'S3BucketArn', ], 'StartupScriptS3ObjectVersion' => [ 'shape' => 'S3ObjectVersion', ], 'StartupScriptS3Path' => [ 'shape' => 'RelativePath', ], 'WebserverAccessMode' => [ 'shape' => 'WebserverAccessMode', ], 'WeeklyMaintenanceWindowStart' => [ 'shape' => 'WeeklyMaintenanceWindowStart', ], ], ], 'UpdateEnvironmentOutput' => [ 'type' => 'structure', 'members' => [ 'Arn' => [ 'shape' => 'EnvironmentArn', ], ], ], 'UpdateError' => [ 'type' => 'structure', 'members' => [ 'ErrorCode' => [ 'shape' => 'ErrorCode', ], 'ErrorMessage' => [ 'shape' => 'ErrorMessage', ], ], ], 'UpdateNetworkConfigurationInput' => [ 'type' => 'structure', 'required' => [ 'SecurityGroupIds', ], 'members' => [ 'SecurityGroupIds' => [ 'shape' => 'SecurityGroupList', ], ], ], 'UpdateSource' => [ 'type' => 'string', 'max' => 256, 'min' => 1, 'pattern' => '^.+$', ], 'UpdateStatus' => [ 'type' => 'string', 'enum' => [ 'SUCCESS', 'PENDING', 'FAILED', ], ], 'ValidationException' => [ 'type' => 'structure', 'members' => [ 'message' => [ 'shape' => 'String', ], ], 'error' => [ 'httpStatusCode' => 400, 'senderFault' => true, ], 'exception' => true, ], 'WebserverAccessMode' => [ 'type' => 'string', 'enum' => [ 'PRIVATE_ONLY', 'PUBLIC_ONLY', ], ], 'WebserverUrl' => [ 'type' => 'string', 'max' => 256, 'min' => 1, 'pattern' => '^https://.+$', ], 'WeeklyMaintenanceWindowStart' => [ 'type' => 'string', 'max' => 9, 'min' => 1, 'pattern' => '(MON|TUE|WED|THU|FRI|SAT|SUN):([01]\\d|2[0-3]):(00|30)', ], ],];
