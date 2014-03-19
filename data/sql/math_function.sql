INSERT INTO `math_function` (`name`, `functionType`, `min`, `max`, `unit`, `higherIsBetter`, `description`, `source_code`) VALUES
('EuclideanDistance', 'Metric', '0', '', '', NULL, NULL, ''),
('PolynomialKernel', 'KernelFunction', '', '', '', NULL, NULL, ''),
('RBFKernel', 'KernelFunction', '', '', '', NULL, NULL, ''),
('area_under_roc_curve', 'EvaluationFunction', '0', '0', '', '1', 'The area under the ROC curve (AUROC), calculated using the Mann-Whitney U-test.\r\n\r\nThe curve is constructed by shifting the threshold for a positive prediction from 0 to 1, yielding a series of true positive rates (TPR) and false positive rates (FPR), from which a step-wise ROC curve can be constructed.\r\n\r\nSee http://en.wikipedia.org/wiki/Receiver_operating_characteristic\r\n\r\nNote that this is different from the Area Under the ROC Convex Hull (ROC AUCH).\r\n\r\nAUROC is defined only for a specific class value, and should thus be labeled with the class value for which is was computed. Use the mean_weighted_area_under_roc_curve for the weighted average over all class values.', 'See WEKA''s ThresholdCurve class.'),
('average_cost', 'EvaluationFunction', '-Inf', 'Inf', '', '0', NULL, ''),
('build_cpu_time', 'EvaluationFunction', '0', 'Inf', 'seconds', '0', 'The time in seconds to build a single model on all data.', ''),
('build_memory', 'EvaluationFunction', '0', 'Inf', 'bytes', '0', 'The memory, in bytes, needed to build a single model on all data.', ''),
('class_complexity', 'EvaluationFunction', '0', 'Inf', 'bits', '1', 'Entropy, in bits, of the class distribution generated by the model''s predictions. Calculated by taking the sum of -log2(predictedProb) over all instances, where predictedProb is the probability (according to the model) of the actual class for that instance. If instances are weighted, the weighted sum is taken.', 'See WEKA''s Evaluation class\r\n'),
('class_complexity_gain', 'EvaluationFunction', '-Inf', 'Inf', 'bits', '1', 'Entropy reduction, in bits, between the class distribution generated by the model''s predictions, and the prior class distribution. Calculated by taking the difference of the prior_class_complexity and the class_complexity.', 'See WEKA''s Evaluation class\r\n'),
('confusion_matrix', 'EvaluationFunction', '', '', '', '1', 'The confusion matrix, or contingency table, is a table that summarizes the number of instances that were predicted to belong to a certain class, versus their actual class. It is an NxN matrix where N is the number of different class values, with the predicted classes in the columns and the actual classes in the rows. \r\n\r\nIn the case of 2 class values (positive and negative), the fields in the matrix are respectively, from left-to-right, top-to-bottom, the number of true positives (TP), false negatives (FN), false positives (FP) and true negatives (TN).\r\n\r\nThe number of correctly classified instances is the sum of diagonals in the matrix; all others are incorrectly classified (e.g. class ”a” gets misclassified as ”b”).\r\n\r\nSee:\r\nhttp://en.wikipedia.org/wiki/Confusion_matrix\r\n\r\nThe values of the confusion matrix are each labeled with the actual and predicted class, e.g. ''actual=pos, predicted=neg''.', 'See WEKA''s Evaluation class\r\n'),
('correlation_coefficient', 'EvaluationFunction', '-1', '1', '', '1', 'The sample Pearson correlation coefficient, or ''r'':\r\n\r\n<math>r = \\frac{\\sum ^n _{i=1}(X_i - \\bar{X})(Y_i - \\bar{Y})}{\\sqrt{\\sum ^n _{i=1}(X_i - \\bar{X})^2} \\sqrt{\\sum ^n _{i=1}(Y_i - \\bar{Y})^2}}</math>\r\n\r\nIt measures the correlation (linear dependence) between the actual predictions and the model''s predictions, giving a value between +1 and −1 inclusive.\r\n\r\nSee:\r\nhttp://en.wikipedia.org/wiki/Pearson_product-moment_correlation_coefficient', 'WEKA''s Evaluation.correlationCoefficient()\r\n\r\n  /**\r\n   * Returns the correlation coefficient if the class is numeric.\r\n   *\r\n   * @return the correlation coefficient\r\n   * @throws Exception if class is not numeric\r\n   */\r\n  public final double correlationCoefficient() throws Exception {\r\n\r\n    if (m_ClassIsNominal) {\r\n      throw\r\n	new Exception("Can''t compute correlation coefficient: " + \r\n		      "class is nominal!");\r\n    }\r\n\r\n    double correlation = 0;\r\n    double varActual = \r\n      m_SumSqrClass - m_SumClass * m_SumClass / \r\n      (m_WithClass - m_Unclassified);\r\n    double varPredicted = \r\n      m_SumSqrPredicted - m_SumPredicted * m_SumPredicted / \r\n      (m_WithClass - m_Unclassified);\r\n    double varProd = \r\n      m_SumClassPredicted - m_SumClass * m_SumPredicted / \r\n      (m_WithClass - m_Unclassified);\r\n\r\n    if (varActual * varPredicted <= 0) {\r\n      correlation = 0.0;\r\n    } else {\r\n      correlation = varProd / Math.sqrt(varActual * varPredicted);\r\n    }\r\n\r\n    return correlation;\r\n  }\r\n'),
('f_measure', 'EvaluationFunction', '0', '0', '', '1', 'The F-Measure is the harmonic mean of precision and recall, also known as the the traditional F-measure, balanced F-score, or F1-score:\r\n\r\nFormula:\r\n2*Precision*Recall/(Precision+Recall)\r\n\r\nSee:\r\nhttp://en.wikipedia.org/wiki/Precision_and_recall\r\n\r\nF-measure is defined only for a specific class value, and should thus be labeled with the class value for which is was computed. Use the mean_weighted_f_measure for the weighted average over all class values.', 'WEKA''s Evaluation.fMeasure(int classIndex):\r\n\r\n  /**\r\n   * Calculate the F-Measure with respect to a particular class. \r\n   * This is defined as<p/>\r\n   * <pre>\r\n   * 2 * recall * precision\r\n   * ----------------------\r\n   *   recall + precision\r\n   * </pre>\r\n   *\r\n   * @param classIndex the index of the class to consider as "positive"\r\n   * @return the F-Measure\r\n   */\r\n  public double fMeasure(int classIndex) {\r\n\r\n    double precision = precision(classIndex);\r\n    double recall = recall(classIndex);\r\n    if ((precision + recall) == 0) {\r\n      return 0;\r\n    }\r\n    return 2 * precision * recall / (precision + recall);\r\n  }'),
('kappa', 'EvaluationFunction', '-1', '1', '', '1', 'Cohen''s kappa coefficient is a statistical measure of agreement for qualitative (categorical) items: it measures the agreement of prediction with the true class – 1.0 signifies complete agreement. \r\n\r\nIt is generally thought to be a more robust measure than simple percent agreement calculation since kappa takes into account the agreement occurring by chance. However, some researchers have expressed concern over kappa''s tendency to take the observed categories'' frequencies as givens, which can have the effect of underestimating agreement for a category that is also commonly used; for this reason, kappa is considered an overly conservative measure of agreement.\r\n\r\nThe equation for kappa is:\r\n\r\n<math>\\kappa = \\frac{\\Pr(a) - \\Pr(e)}{1 - \\Pr(e)}, \\!</math>\r\n\r\nwhere Pr(a) is the relative observed agreement among raters, and Pr(e) is the hypothetical probability of chance agreement, using the observed data to calculate the probabilities of each observer randomly saying each category.  If the raters are in complete agreement then kappa = 1.  If there is no agreement among the raters other than what would be expected by chance (as defined by Pr(e)), kappa = 0.\r\n\r\nSee: Cohen, Jacob (1960). A coefficient of agreement for nominal scales. Educational and Psychological Measurement 20 (1): 37–46.', 'WEKA''s Evaluation.kappa(), based on the confusion matrix.\r\n\r\npublic final double kappa() {\r\n    \r\n    double[] sumRows = new double[m_ConfusionMatrix.length];\r\n    double[] sumColumns = new double[m_ConfusionMatrix.length];\r\n    double sumOfWeights = 0;\r\n    for (int i = 0; i < m_ConfusionMatrix.length; i++) {\r\n      for (int j = 0; j < m_ConfusionMatrix.length; j++) {\r\n	sumRows[i] += m_ConfusionMatrix[i][j];\r\n	sumColumns[j] += m_ConfusionMatrix[i][j];\r\n	sumOfWeights += m_ConfusionMatrix[i][j];\r\n      }\r\n    }\r\n    double correct = 0, chanceAgreement = 0;\r\n    for (int i = 0; i < m_ConfusionMatrix.length; i++) {\r\n      chanceAgreement += (sumRows[i] * sumColumns[i]);\r\n      correct += m_ConfusionMatrix[i][i];\r\n    }\r\n    chanceAgreement /= (sumOfWeights * sumOfWeights);\r\n    correct /= sumOfWeights;\r\n\r\n    if (chanceAgreement < 1) {\r\n      return (correct - chanceAgreement) / (1 - chanceAgreement);\r\n    } else {\r\n      return 1;\r\n    }\r\n}'),
('kb_relative_information_score', 'EvaluationFunction', '-Inf', 'Inf', '', '1', 'The Kononenko and Bratko Information score, divided by the prior entropy of the class distribution.\r\n\r\nSee:\r\nKononenko, I., Bratko, I.: Information-based evaluation criterion for classier''s performance. Machine\r\nLearning 6 (1991) 67-80', ''),
('kohavi_wolpert_bias_squared', 'EvaluationFunction', '', '', '', '0', 'Bias component (squared) of the bias-variance decomposition as defined by Kohavi and Wolpert in:\r\n\r\nR. Kohavi & D. Wolpert (1996), Bias plus variance decomposition for zero-one loss functions, in Proc. of the Thirteenth International Machine Learning Conference (ICML96)\r\n\r\nThis quantity measures how closely\r\nthe learning algorithms average guess over all possible training sets of the given training set size matches the target.\r\n\r\nEstimated using the classifier using the sub-sampled cross-validation procedure as specified in:\r\n\r\nGeoffrey I. Webb & Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia', 'See WEKA''s BVDecompose class'),
('kohavi_wolpert_error', 'EvaluationFunction', '', '', '', '0', 'Error rate measured in the bias-variance decomposition as defined by Kohavi and Wolpert in:\r\n\r\nR. Kohavi & D. Wolpert (1996), Bias plus variance decomposition for zero-one loss functions, in Proc. of the Thirteenth International Machine Learning Conference (ICML96)\r\n\r\nEstimated using the classifier using the sub-sampled cross-validation procedure as specified in:\r\n\r\nGeoffrey I. Webb & Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia', 'See WEKA''s BVDecompose class'),
('kohavi_wolpert_sigma_squared', 'EvaluationFunction', '', '', '', '0', 'Intrinsic error component (squared) of the bias-variance decomposition as defined by Kohavi and Wolpert in:\r\n\r\nR. Kohavi and D. Wolpert (1996), Bias plus variance decomposition for zero-one loss functions, in Proc. of the Thirteenth International Machine Learning Conference (ICML96)\r\n\r\nThis quantity is a lower bound on the expected cost of any learning algorithm. It is the expected cost of the Bayes optimal classifier.\r\n\r\nEstimated using the classifier using the sub-sampled cross-validation procedure as specified in:\r\n\r\nGeoffrey I. Webb & Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia', 'See WEKA''s BVDecompose class'),
('kohavi_wolpert_variance', 'EvaluationFunction', '', '', '', '0', 'Variance component of the bias-variance decomposition as defined by Kohavi and Wolpert in:\r\n\r\nR. Kohavi and D. Wolpert (1996), Bias plus variance decomposition for zero-one loss functions, in Proc. of the Thirteenth International Machine Learning Conference (ICML96)\r\n\r\nThis quantity measures how much the\r\nlearning algorithms guess "bounces around" for the different training sets of the given size.\r\n\r\nEstimated using the classifier using the sub-sampled cross-validation procedure as specified in:\r\n\r\nGeoffrey I. Webb & Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia', 'See WEKA''s BVDecompose class'),
('kononenko_bratko_information_score', 'EvaluationFunction', '-Inf', 'Inf', '', '1', 'Kononenko and Bratko Information score. This measures predictive accuracy but eliminates the influence of prior probabilities.\r\n\r\nSee:\r\nKononenko, I., Bratko, I.: Information-based evaluation criterion for classier''s performance. Machine\r\nLearning 6 (1991) 67-80', 'See WEKA''s Evaluation class\r\n'),
('matthews_correlation_coefficient', 'EvaluationFunction', '-1', '1', '', '1', 'The Matthews correlation coefficient takes into account true and false positives and negatives and is generally regarded as a balanced measure which can be used even if the classes are of very different sizes. The MCC is in essence a correlation coefficient between the observed and predicted binary classifications; it returns a value between −1 and +1. A coefficient of +1 represents a perfect prediction, 0 no better than random prediction and −1 indicates total disagreement between prediction and observation. The statistic is also known as the phi coefficient. MCC is related to the chi-square statistic for a 2×2 contingency table.\r\n\r\nThe MCC can be calculated directly from the confusion matrix using the formula:\r\n\r\n<math>\r\n\\text{MCC} = \\frac{ TP \\times TN - FP \\times FN } {\\sqrt{ (TP + FP) ( TP + FN ) ( TN + FP ) ( TN + FN ) } }\r\n</math>\r\n\r\nSee:\r\nhttp://en.wikipedia.org/wiki/Matthews_correlation_coefficient\r\n', ''),
('mean_absolute_error', 'EvaluationFunction', '0', '1', '', '0', 'The mean absolute error (MAE) measures how close the model''s predictions are to the actual target values. It is the sum of the absolute value of the difference of each instance prediction and the actual value. For classification, the 0/1-error is used.\r\n\r\n<math>\\mathrm{MAE} = \\frac{1}{n}\\sum_{i=1}^n \\left| f_i-y_i\\right| =\\frac{1}{n}\\sum_{i=1}^n \\left| e_i \\right|.</math>\r\n\r\nSee:\r\nhttp://en.wikipedia.org/wiki/Mean_absolute_error', 'See WEKA''s Evaluation class\r\n\r\n'),
('mean_class_complexity', 'EvaluationFunction', '0', 'Inf', '', '1', 'The entropy of the class distribution generated by the model (see class_complexity), divided by the number of instances in the input data.', 'See WEKA''s Evaluation class\r\n'),
('mean_class_complexity_gain', 'EvaluationFunction', '-Inf', 'Inf', '', '1', 'The entropy gain of the class distribution  by the model over the prior distribution (see class_complexity_gain), divided by the number of instances in the input data.', 'See WEKA''s Evaluation class\r\n'),
('mean_f_measure', 'EvaluationFunction', '0', '1', '', '1', 'Unweighted(!) macro-average F-Measure. \r\n\r\nIn macro-averaging, F-measure is computed\r\nlocally over each category ﬁrst and then the average over all categories is taken.', 'See WEKA''s Evaluation class\r\n'),
('mean_kononenko_bratko_information_score', 'EvaluationFunction', '-Inf', 'Inf', '', '1', 'Kononenko and Bratko Information score, see kononenko_bratko_information_score, divided by the number of instances in the input data.\r\n\r\nSee:\r\nKononenko, I., Bratko, I.: Information-based evaluation criterion for classier''s performance. Machine\r\nLearning 6 (1991) 67-80', 'See WEKA''s Evaluation class\r\n'),
('mean_precision', 'EvaluationFunction', '0', '1', '', '1', 'Unweighted(!) macro-average Precision. \r\n\r\nIn macro-averaging, Precision is computed\r\nlocally over each category ﬁrst and then the average over all categories is taken.', 'See WEKA''s Evaluation class\r\n'),
('mean_prior_absolute_error', 'EvaluationFunction', '0', '1', '', '0', 'The mean prior absolute error (MPAE) is the mean absolute error (see mean_absolute_error) of the prior (e.g., default class prediction).\r\n\r\nSee:\r\nhttp://en.wikipedia.org/wiki/Mean_absolute_error', 'See WEKA''s Evaluation class\r\n'),
('mean_prior_class_complexity', 'EvaluationFunction', '0', 'Inf', '', '1', 'The entropy of the class distribution of the prior (see prior_class_complexity), divided by the number of instances in the input data.', 'See WEKA''s Evaluation class\r\n'),
('mean_recall', 'EvaluationFunction', '0', '1', '', '1', 'Unweighted(!) macro-average Recall. \r\n\r\nIn macro-averaging, Recall is computed\r\nlocally over each category ﬁrst and then the average over all categories is taken.', 'See WEKA''s Evaluation class\r\n'),
('mean_weighted_area_under_roc_curve', 'EvaluationFunction', '0', '1', '', '1', 'The macro weighted (by class size) average area_under_ROC_curve (AUROC). \r\n\r\nIn macro-averaging, AUROC is computed\r\nlocally over each category ﬁrst and then the average over all categories is taken, weighted by the number of instances of that class.\r\n\r\nConversely, in micro-averaging, AUROC is computed globally over all category decisions.', 'See WEKA''s Evaluation class\r\n'),
('mean_weighted_f_measure', 'EvaluationFunction', '0', '1', '', '1', 'The macro weighted (by class size) average F-Measure. \r\n\r\nIn macro-averaging, F-measure is computed\r\nlocally over each category ﬁrst and then the average over all categories is taken, weighted by the number of instances of that class.\r\n\r\nConversely, in micro-averaging, F-measure is computed globally over all category decisions.', 'See WEKA''s Evaluation class\r\n'),
('mean_weighted_precision', 'EvaluationFunction', '0', '1', '', '1', 'The macro weighted (by class size) average Precision. \r\n\r\nIn macro-averaging, Precision is computed\r\nlocally over each category ﬁrst and then the average over all categories is taken, weighted by the number of instances of that class.\r\n\r\nConversely, in micro-averaging, Precision is computed globally over all category decisions.', 'See WEKA''s Evaluation class\r\n'),
('mean_weighted_recall', 'EvaluationFunction', '0', '1', '', '1', 'The macro weighted (by class size) average Recall. \r\n\r\nIn macro-averaging, Recall is computed\r\nlocally over each category ﬁrst and then the average over all categories is taken, weighted by the number of instances of that class.\r\n\r\nConversely, in micro-averaging, Recall is computed globally over all category decisions.', 'See WEKA''s Evaluation class\r\n'),
('number_of_instances', 'EvaluationFunction', '0', 'inf', '', NULL, 'The number of instances used for this evaluation. ', ''),
('precision', 'EvaluationFunction', '0', '0', '', '1', 'Precision is defined as the number of true positive (TP) predictions, divided by the sum of the number of true positives and false positives (TP+FP):\r\n\r\n<math>\\text{Precision}=\\frac{tp}{tp+fp} \\, </math>\r\n\r\nIt is also referred to as the Positive predictive value (PPV).\r\n\r\nSee:\r\nhttp://en.wikipedia.org/wiki/Precision_and_recall\r\n\r\nPrecision is defined only for a specific class value, and should thus be labeled with the class value for which is was computed. Use the mean_weighted_precision for the weighted average over all class values.', 'WEKA''s Evaluation.precision(int classIndex)\r\n\r\n /**\r\n   * Calculate the precision with respect to a particular class. \r\n   * This is defined as<p/>\r\n   * <pre>\r\n   * correctly classified positives\r\n   * ------------------------------\r\n   *  total predicted as positive\r\n   * </pre>\r\n   *\r\n   * @param classIndex the index of the class to consider as "positive"\r\n   * @return the precision\r\n   */\r\n  public double precision(int classIndex) {\r\n\r\n    double correct = 0, total = 0;\r\n    for (int i = 0; i < m_NumClasses; i++) {\r\n      if (i == classIndex) {\r\n	correct += m_ConfusionMatrix[i][classIndex];\r\n      }\r\n      total += m_ConfusionMatrix[i][classIndex];\r\n    }\r\n    if (total == 0) {\r\n      return 0;\r\n    }\r\n    return correct / total;\r\n}'),
('predictive_accuracy', 'EvaluationFunction', '0', '1', '', '1', 'The Predictive Accuracy is the percentage of instances that are classified correctly. Is it 1 - ErrorRate.', 'See WEKA''s Evaluation class\r\n'),
('prior_class_complexity', 'EvaluationFunction', '0', 'Inf', 'bits', '1', 'Entropy, in bits, of the prior class distribution. Calculated by taking the sum of -log2(priorProb) over all instances, where priorProb is the prior probability of the actual class for that instance. If instances are weighted, the weighted sum is taken.', 'See WEKA''s Evaluation class\r\n'),
('prior_entropy', 'EvaluationFunction', '0', 'Inf', 'bits', '1', 'Entropy, in bits, of the prior class distribution. Calculated by taking the sum of -log2(priorProb) over all instances, where priorProb is the prior probability of the actual class for that instance. If instances are weighted, the weighted sum is taken.', 'See WEKA''s Evaluation class\r\n'),
('os_information', 'EvaluationFunction', '', '', '', '', 'Default information about OS, JVM, installations, etc. ', ''),
('ram_hours', 'EvaluationFunction', '0', 'Inf', 'GB RAM x hours', '0', 'Every GB of RAM deployed for 1 hour equals one RAM-Hour.', ''),
('recall', 'EvaluationFunction', '0', '0', '', '1', 'Recall is defined as the number of true positive (TP) predictions, divided by the sum of the number of true positives and false negatives (TP+FN):\r\n\r\n<math>\\text{Recall}=\\frac{tp}{tp+fn} \\, </math>\r\n\r\nIt is also referred to as the True Positive Rate (TPR) or Sensitivity.\r\n\r\nSee:\r\nhttp://en.wikipedia.org/wiki/Precision_and_recall\r\n\r\nRecall is defined only for a specific class value, and should thus be labeled with the class value for which is was computed. Use the mean_weighted_recall for the weighted average over all class values.', 'WEKA''s Evaluation.truePositiveRate(int classIndex):\r\n\r\n /**\r\n   * Calculate the true positive rate with respect to a particular class. \r\n   * This is defined as<p/>\r\n   * <pre>\r\n   * correctly classified positives\r\n   * ------------------------------\r\n   *       total positives\r\n   * </pre>\r\n   *\r\n   * @param classIndex the index of the class to consider as "positive"\r\n   * @return the true positive rate\r\n   */\r\n  public double truePositiveRate(int classIndex) {\r\n\r\n    double correct = 0, total = 0;\r\n    for (int j = 0; j < m_NumClasses; j++) {\r\n      if (j == classIndex) {\r\n	correct += m_ConfusionMatrix[classIndex][j];\r\n      }\r\n      total += m_ConfusionMatrix[classIndex][j];\r\n    }\r\n    if (total == 0) {\r\n      return 0;\r\n    }\r\n    return correct / total;\r\n}'),
('relative_absolute_error', 'EvaluationFunction', '0', '1', '', '0', 'The Relative Absolute Error (RAE) is the mean absolute error (MAE) divided by the mean prior absolute error (MPAE).', 'See WEKA''s Evaluation class\r\n'),
('root_mean_prior_squared_error', 'EvaluationFunction', '0', '1', '', '0', 'The Root Mean Prior Squared Error (RMPSE) is the Root Mean Squared Error (RMSE) of the prior (e.g., the default class prediction).', 'See WEKA''s Evaluation class\r\n'),
('root_mean_squared_error', 'EvaluationFunction', '0', '1', '', '0', 'The Root Mean Squared Error (RMSE) measures how close the model''s predictions are to the actual target values. It is the square root of the Mean Squared Error (MSE), the sum of the squared differences between the predicted value and the actual value. For classification, the 0/1-error is used.\r\n\r\n:<math>\\operatorname{MSE}(\\overline{X})=\\operatorname{E}((\\overline{X}-\\mu)^2)=\\left(\\frac{\\sigma}{\\sqrt{n}}\\right)^2= \\frac{\\sigma^2}{n}</math>\r\n\r\nSee:\r\nhttp://en.wikipedia.org/wiki/Mean_squared_error', 'See WEKA''s Evaluation class\r\n'),
('root_relative_squared_error', 'EvaluationFunction', '0', '1', '', '0', 'The Root Relative Squared Error (RRSE) is the Root Mean Squared Error (RMSE) divided by the Root Mean Prior Squared Error (RMPSE). See root_mean_squared_error and root_mean_prior_squared_error.', 'See WEKA''s Evaluation class\r\n'),
('run_cpu_time', 'EvaluationFunction', '0', 'Inf', 'seconds', '0', 'Runtime in seconds of the entire run. In the case of cross-validation runs, this will include all iterations.', ''),
('run_memory', 'EvaluationFunction', '0', 'Inf', 'bytes', '0', 'Amount of memory, in bytes, used during  the entire run.', ''),
('run_virtual_memory', 'EvaluationFunction', '0', 'Inf', 'bytes', '0', 'Amount of virtual memory, in bytes, used during  the entire run.', ''),
('scimark_benchmark', 'EvaluationFunction', '0', 'Inf', 'MFlops', '1', 'A benchmark tool which measures (single core) CPU performance on the JVM. ', 'See http://math.nist.gov/scimark2/'),
('single_point_area_under_roc_curve', 'EvaluationFunction', '0', '1', '', '1', NULL, ''),
('total_cost', 'EvaluationFunction', '-Inf', 'Inf', '', '0', NULL, ''),
('unclassified_instance_count', 'EvaluationFunction', '0', 'Inf', 'instances', '1', 'Number of instances that were not classified by the model.', 'See WEKA''s Evaluation class\r\n'),
('webb_bias', 'EvaluationFunction', '', '', '', '0', 'Bias component (squared) of the bias-variance decomposition as defined by Webb in:\r\n\r\nGeoffrey I. Webb (2000), MultiBoosting: A Technique for Combining Boosting and Wagging, Machine Learning, 40(2), pages 159-196.\r\n\r\nThis quantity measures how closely\r\nthe learning algorithms average guess over all possible training sets of the given training set size matches the target.\r\n\r\nEstimated using the classifier using the sub-sampled cross-validation procedure as specified in:\r\n\r\nGeoffrey I. Webb & Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia', 'See WEKA''s BVDecompose class'),
('webb_error', 'EvaluationFunction', '', '', '', '0', 'Intrinsic error component (squared) of the bias-variance decomposition as defined by Webb in:\r\n\r\nGeoffrey I. Webb (2000), MultiBoosting: A Technique for Combining Boosting and Wagging, Machine Learning, 40(2), pages 159-196.\r\n\r\nThis quantity is a lower bound on the expected cost of any learning algorithm. It is the expected cost of the Bayes optimal classifier.\r\n\r\nEstimated using the classifier using the sub-sampled cross-validation procedure as specified in:\r\n\r\nGeoffrey I. Webb & Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia', 'See WEKA''s BVDecompose class'),
('webb_variance', 'EvaluationFunction', '', '', '', '0', 'Variance component of the bias-variance decomposition as defined by Webb in:\r\n\r\nGeoffrey I. Webb (2000), MultiBoosting: A Technique for Combining Boosting and Wagging, Machine Learning, 40(2), pages 159-196.\r\n\r\nThis quantity measures how much the\r\nlearning algorithms guess "bounces around" for the different training sets of the given size.\r\n\r\nEstimated using the classifier using the sub-sampled cross-validation procedure as specified in:\r\n\r\nGeoffrey I. Webb & Paul Conilione (2002), Estimating bias and variance from data , School of Computer Science and Software Engineering, Monash University, Australia', 'See WEKA''s BVDecompose class');
