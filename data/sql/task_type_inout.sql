INSERT INTO `task_type_inout` (`ttid`, `name`, `type`, `io`, `requirement`, `description`, `order`, `template_api`, `template_search`) VALUES
(1, 'custom_testset', 'KeyValue', 'input', 'hidden', 'If applicable, the user can specify a custom testset', 22, NULL, '{ "name": "Specify row id''s (0-based):", "placeholder": "Experimental. Only allowed with one dataset selected in the dataset(s) field"}'),
(1, 'estimation_procedure', 'Estimation Procedure', 'input', 'required', 'The estimation procedure used to validate the generated models', 20, '<oml:estimation_procedure>\r\n<oml:type>[LOOKUP:estimation_procedure.type]</oml:type>\r\n<oml:data_splits_url>[CONSTANT:base_url]api_splits/get/[TASK:id]/Task_[TASK:id]_splits.arff</oml:data_splits_url>\r\n<oml:parameter name="number_repeats">[LOOKUP:estimation_procedure.repeats]</oml:parameter>\r\n<oml:parameter name="number_folds">[LOOKUP:estimation_procedure.folds]</oml:parameter>\r\n<oml:parameter name="percentage">[LOOKUP:estimation_procedure.percentage]</oml:parameter>\r\n<oml:parameter name="stratified_sampling">[LOOKUP:estimation_procedure.stratified_sampling]</oml:parameter>\r\n</oml:estimation_procedure>', '{\r\n  "type": "select",\r\n  "table": "estimation_procedure",\r\n  "key": "id",\r\n  "value": "name"\r\n}'),
(1, 'evaluations', 'KeyValue', 'output', 'optional', 'A list of user-defined evaluations of the task as key-value pairs.', 50, NULL, NULL),
(1, 'evaluation_measures', 'String', 'input', 'optional', 'The evaluation measures to optimize for, e.g., cpu time, accuracy', 30, '<oml:evaluation_measures>\r\n<oml:evaluation_measure>[INPUT:evaluation_measures]</oml:evaluation_measure>\r\n</oml:evaluation_measures>', '{\r\n  "autocomplete": "plain",\r\n  "datasource": "expdbEvaluationMetrics()"\r\n}'),
(1, 'model', 'File', 'output', 'optional', 'A file containing the model built on all the input data.', 60, NULL, NULL),
(1, 'predictions', 'Predictions', 'output', 'optional', 'The desired output format', 40, '<oml:predictions>\r\n<oml:format>ARFF</oml:format>\r\n<oml:feature name="repeat" type="integer"/>\r\n<oml:feature name="fold" type="integer"/>\r\n<oml:feature name="row_id" type="integer"/>\r\n<oml:feature name="confidence.classname" type="numeric"/>\r\n<oml:feature name="prediction" type="string"/>\r\n</oml:predictions>', NULL),
(1, 'source_data', 'Dataset', 'input', 'required', 'The dataset and target feature of a task', 10, '<oml:data_set>\r\n<oml:data_set_id>[INPUT:source_data]</oml:data_set_id>\r\n<oml:target_feature>[INPUT:target_feature]</oml:target_feature>\r\n</oml:data_set>', '{\r\n  "name": "Dataset(s)",\r\n  "autocomplete": "commaSeparated",\r\n  "datasource": "expdbDatasetVersion()",\r\n  "placeholder": "(*) include all datasets"\r\n}'),
(1, 'target_feature', 'String', 'input', 'required', 'The name of the dataset feature to be used as the target feature.', 15, NULL, '{\r\n  "placeholder": "Use default target"\r\n}'),
(2, 'estimation_procedure', 'Estimation Procedure', 'input', 'required', 'The estimation procedure used to validate the generated models', 20, '<oml:estimation_procedure>\r\n<oml:type>[LOOKUP:estimation_procedure.type]</oml:type>\r\n<oml:data_splits_url>[CONSTANT:base_url]/api_splits/get/[TASK:id]/Task_[TASK:id]_splits.arff</oml:data_splits_url>\r\n<oml:parameter name="number_repeats">[LOOKUP:estimation_procedure.repeats]</oml:parameter>\r\n<oml:parameter name="number_folds">[LOOKUP:estimation_procedure.folds]</oml:parameter>\r\n<oml:parameter name="percentage">[LOOKUP:estimation_procedure.percentage]</oml:parameter>\r\n</oml:estimation_procedure>', '{\r\n  "type": "select",\r\n  "table": "estimation_procedure",\r\n  "key": "id",\r\n  "value": "name"\r\n}'),
(2, 'evaluations', 'KeyValue', 'output', 'optional', 'A list of user-defined evaluations of the task as key-value pairs.', 50, NULL, NULL),
(2, 'evaluation_measures', 'String', 'input', 'optional', 'The evaluation measures to optimize for, e.g., cpu time, accuracy', 30, '<oml:evaluation_measures>\r\n<oml:evaluation_measure>[INPUT:evaluation_measures]</oml:evaluation_measure>\r\n</oml:evaluation_measures>', '{\r\n  "autocomplete": "plain",\r\n  "datasource": "expdbEvaluationMetrics()",\r\n  "default": "predictive_accuracy"\r\n}'),
(2, 'model', 'File', 'output', 'optional', 'A file containing the model built on all the input data.', 60, NULL, NULL),
(2, 'predictions', 'Predictions', 'output', 'optional', 'The desired output format', 40, '<oml:predictions>\r\n<oml:format>ARFF</oml:format>\r\n<oml:feature name="repeat" type="integer"/>\r\n<oml:feature name="fold" type="integer"/>\r\n<oml:feature name="row_id" type="integer"/>\r\n<oml:feature name="prediction" type="string"/>\r\n</oml:predictions>', NULL),
(2, 'source_data', 'Dataset', 'input', 'required', 'The dataset and target feature of a task', 10, '<oml:data_set>\r\n<oml:data_set_id>[INPUT:source_data]</oml:data_set_id>\r\n<oml:target_feature>[INPUT:target_feature]</oml:target_feature>\r\n</oml:data_set>', '{\r\n  "name": "Dataset(s)",\r\n  "autocomplete": "commaSeparated",\r\n  "datasource": "expdbDatasetVersion()",\r\n  "placeholder": "(*) include all datasets"\r\n}'),
(2, 'target_feature', 'String', 'input', 'required', 'The name of the dataset feature to be used as the target feature.', 15, NULL, '{\r\n  "default": "class",\r\n  "placeholder": "Use default target"\r\n}'),
(3, 'estimation_procedure', 'Estimation Procedure', 'input', 'required', 'The estimation procedure used to validate the generated models', 20, '<oml:estimation_procedure>\r\n<oml:type>[LOOKUP:estimation_procedure.type]</oml:type>\r\n<oml:data_splits_url>[CONSTANT:base_url]/api_splits/get/[TASK:id]/Task_[TASK:id]_splits.arff</oml:data_splits_url>\r\n<oml:parameter name="number_repeats">[LOOKUP:estimation_procedure.repeats]</oml:parameter>\r\n<oml:parameter name="number_folds">[LOOKUP:estimation_procedure.folds]</oml:parameter>\r\n<oml:parameter name="number_samples">[INPUT:number_samples]</oml:parameter>\r\n</oml:estimation_procedure>', '{\r\n  "type": "select",\r\n  "table": "estimation_procedure",\r\n  "key": "id",\r\n  "value": "name"\r\n}'),
(3, 'evaluations', 'KeyValue', 'output', 'optional', 'A list of user-defined evaluations of the task as key-value pairs.', 50, NULL, NULL),
(3, 'evaluation_measures', 'String', 'input', 'optional', 'The evaluation measures to optimize for, e.g., cpu time, accuracy', 30, '<oml:evaluation_measures>\r\n<oml:evaluation_measure>[INPUT:evaluation_measures]</oml:evaluation_measure>\r\n</oml:evaluation_measures>', '{\r\n  "autocomplete": "plain",\r\n  "datasource": "expdbEvaluationMetrics()"\r\n}'),
(3, 'number_samples', 'String', 'input', 'hidden', 'The (maximum) number of samples to return, or the number of points on the learning curve. The sample sizes grow exponentially as a power of two.', 60, NULL, NULL),
(3, 'predictions', 'Predictions', 'output', 'optional', 'The desired output format', 40, '<oml:predictions>\r\n<oml:format>ARFF</oml:format>\r\n<oml:feature name="repeat" type="integer"/>\r\n<oml:feature name="fold" type="integer"/>\r\n<oml:feature name="sample" type="integer"/>\r\n<oml:feature name="row_id" type="integer"/>\r\n<oml:feature name="confidence.classname" type="numeric"/>\r\n<oml:feature name="prediction" type="string"/>\r\n</oml:predictions>', NULL),
(3, 'source_data', 'Dataset', 'input', 'required', 'The dataset and target feature of a task', 10, '<oml:data_set>\r\n<oml:data_set_id>[INPUT:source_data]</oml:data_set_id>\r\n<oml:target_feature>[INPUT:target_feature]</oml:target_feature>\r\n</oml:data_set>', '{\r\n  "name": "Dataset(s)",\r\n  "autocomplete": "commaSeparated",\r\n  "datasource": "expdbDatasetVersion()",\r\n  "placeholder": "(*) include all datasets"\r\n}'),
(3, 'target_feature', 'String', 'input', 'required', 'The name of the dataset feature to be used as the target feature.', 15, NULL, '{\r\n  "default": "class",\r\n  "placeholder": "Use default target"\r\n}'),
(4, 'estimation_procedure', 'Estimation Procedure', 'input', 'required', 'The estimation procedure used to validate the generated models', 20, '<oml:estimation_procedure>\r\n<oml:type>[LOOKUP:estimation_procedure.type]</oml:type></oml:estimation_procedure>', '{\r\n  "type": "select",\r\n  "table": "estimation_procedure",\r\n  "key": "id",\r\n  "value": "name"\r\n}'),
(4, 'evaluations', 'KeyValue', 'output', 'optional', 'A list of user-defined evaluations of the task as key-value pairs.', 50, NULL, NULL),
(4, 'evaluation_measures', 'String', 'input', 'optional', 'The evaluation measures to optimize for, e.g., cpu time, accuracy', 30, '<oml:evaluation_measures>\r\n<oml:evaluation_measure>[INPUT:evaluation_measures]</oml:evaluation_measure>\r\n</oml:evaluation_measures>', '{\r\n  "autocomplete": "plain",\r\n  "datasource": "expdbEvaluationMetrics()"\r\n}'),
(4, 'predictions', 'Predictions', 'output', 'optional', 'The desired output format', 40, '<oml:predictions>\r\n<oml:format>ARFF</oml:format>\r\n<oml:feature name="row_id" type="integer"/>\r\n<oml:feature name="confidence.classname" type="numeric"/>\r\n<oml:feature name="prediction" type="string"/>\r\n</oml:predictions>', NULL),
(4, 'source_data', 'Dataset', 'input', 'required', 'The dataset and target feature of a task', 10, '<oml:data_set>\r\n<oml:data_set_id>[INPUT:source_data]</oml:data_set_id>\r\n<oml:target_feature>[INPUT:target_feature]</oml:target_feature>\r\n</oml:data_set>', '{\r\n  "name": "Dataset(s)",\r\n  "autocomplete": "commaSeparated",\r\n  "datasource": "expdbDatasetVersion()",\r\n  "placeholder": "(*) include all datasets"\r\n}'),
(4, 'target_feature', 'String', 'input', 'required', 'The name of the dataset feature to be used as the target feature.', 15, NULL, '{\r\n  "default": "class",\r\n  "placeholder": "Use default target"\r\n}'),
(5, 'estimation_procedure', 'Estimation Procedure', 'input', 'required', 'The estimation procedure used to assess the quality of the clustered', 20, '<oml:estimation_procedure>\r\n<oml:type>[LOOKUP:estimation_procedure.type]</oml:type>\r\n<oml:data_splits_url>[CONSTANT:base_url]api_splits/get/[TASK:id]/Task_[TASK:id]_splits.arff</oml:data_splits_url>\r\n<oml:parameter name="number_repeats">[LOOKUP:estimation_procedure.repeats]</oml:parameter>\r\n<oml:parameter name="stratified_sampling">[LOOKUP:estimation_procedure.stratified_sampling]</oml:parameter>\r\n</oml:estimation_procedure>', '{\r\n  "type": "select",\r\n  "table": "estimation_procedure",\r\n  "key": "id",\r\n  "value": "name"\r\n}'),
(5, 'evaluations', 'KeyValue', 'output', 'optional', 'A list of user-defined evaluations of the task as key-value pairs.', 50, NULL, NULL),
(5, 'evaluation_measures', 'String', 'input', 'optional', 'The evaluation measures to optimize for, e.g., log likelihood', 30, '<oml:evaluation_measures>\r\n<oml:evaluation_measure>[INPUT:evaluation_measures]</oml:evaluation_measure>\r\n</oml:evaluation_measures>', '{\r\n  "autocomplete": "plain",\r\n  "datasource": "expdbEvaluationMetrics()"\r\n}'),
(5, 'model', 'File', 'output', 'optional', 'A file containing the model built on all the input data.', 60, NULL, NULL),
(5, 'predictions', 'Predictions', 'output', 'optional', 'The desired output format', 40, '<oml:predictions>\r\n<oml:format>ARFF</oml:format>\r\n<oml:feature name="repeat" type="numeric"/>\r\n<oml:feature name="row_id" type="numeric"/>\r\n<oml:feature name="cluster" type="numeric"/>\r\n</oml:predictions>', NULL),
(5, 'source_data', 'Dataset', 'input', 'required', 'The dataset of a task', 10, '<oml:data_set>\r\n<oml:data_set_id>[INPUT:source_data]</oml:data_set_id>\r\n</oml:data_set>', '{\r\n  "name": "Dataset(s)",\r\n  "autocomplete": "commaSeparated",\r\n  "datasource": "expdbDatasetVersion()",\r\n  "placeholder": "(*) include all datasets"\r\n}');

