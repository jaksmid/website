INSERT INTO `algorithm` (`name`, `function`, `description`, `algorithm_class`) VALUES
('ADTree', 'Build alternating decision trees', 'ADTree builds an alternating decision tree using boosting and is optimized for two-class problems. The number of boosting iterations is a parameter that can be tuned to suit the dataset and the desired complexity-accuracy tradeoff. Each iteration adds three nodes to the tree (one split node and two prediction nodes) unless nodes can be merged. The default search method is exhaustive search (expand all paths); the other are heuristics and are much faster.', 'trees'),
('AODE', 'Averaged, One-Dependence Estimators', 'Averaged, One-Dependence Estimators is a Bayesian method that averages over a space of alternative Bayesian models that have weaker independence assumptions than Naive Bayes (Webb et al., 2005). The algorithm may yield more accurate classification than Naive Bayes on datasets with nonindependent attributes.', 'bayes'),
('ARFFLoader', NULL, NULL, 'DataPreprocessor'),
('AdaBoost', 'Boost using the AdaBoostM1 method', NULL, 'meta'),
('AdditiveRegression', 'Enhance the performance of a regression method by iteratively fitting the residuals', NULL, 'meta'),
('AttributeSelection', NULL, NULL, 'DataPreprocessor'),
('AttributeSelectionWrapper', 'Reduce dimensionality of data by attribute selection', NULL, 'meta'),
('Bagging', 'Bag a classifier; works for regression too', NULL, 'meta'),
('BayesianNet', 'Learn Bayesian nets', 'BayesNet learns Bayesian networks under the assumptions of nominal attributes (numeric ones are prediscretized) and no missing values (any such are values are replaced globally). There are two different algorithms for estimating the conditional probability tables of the network. Search is done using the K2 or TAN algorithm or more sophisticated methods based on hill-climbing, simulated annealing, tabu search, and genetic algorithms. Optionally, search speed can be improved using AD trees.', 'bayes'),
('BestFirstSearch', NULL, 'Best-first search algorithm', 'search'),
('C4.5', 'C4.5 (revision 8) decision tree learner ', 'Reimplementation of C4.5', 'trees'),
('CVParameterSelectionWrapper', 'Perform parameter selection by cross-validation', NULL, 'meta'),
('ClassificationViaRegressionWrapper', 'Perform classification using a regression method', NULL, 'meta'),
('ConjunctiveRule', 'Simple conjunctive rule learner', NULL, 'rules'),
('CorrelationBasedFeatureSubsetEvaluation', NULL, 'Evaluates the worth of a subset of attributes by considering the individual predictive ability of each feature along with the degree of redundancy between them. Subsets of features that are highly correlated with the class while having low intercorrelation are preferred.\r\n', 'FeatureSubsetEvaluator'),
('CrossValidationSelectionWrapper', 'Use cross-validation to select a classifier from several candidates', NULL, 'meta'),
('DecisionStump', 'Build one-level decision trees', 'Designed for use with boosting methods, builds one-level binary decision trees for datasets with a categorical or numeric class, dealing with missing values by treating them as a separate value and extending a third branch from the stump.', 'trees'),
('DecisionTable', 'Build a simple decision table majority classifier', 'DecisionTable builds a decision table majority classifier. It evaluates feature subsets using best-first search and can use cross-validation for evaluation. An option uses the nearest-neighbor method to determine the class for each instance that is not covered by a decision table entry, instead of the table''s global majority, based on the same set of features.', 'rules'),
('Decorate', 'Build ensembles of classifiers by using specially constructed artificial training examples', NULL, 'meta'),
('FilterWrapper', 'Run a classifier on filtered data', NULL, 'meta'),
('HyperPipes', 'Extremely simple, fast learner based on hypervolumes in instance space', NULL, 'misc'),
('Id3', 'Basic divide-and-conquer decision tree algorithm', 'Basic decision tree learner using the information gain criterion. Has no support for dealing with numeric attributes, missing values, noisy data and generating rules for trees.', 'trees'),
('IncrementalNaiveBayes', 'Incremental Naive Bayes Classifier that learns one instance at a time', 'Incremental version of Naive Bayes that processes on instance at a time; it can use a kernel estimator but not discretization.', 'bayes'),
('KStar', 'Nearest neighbor with generalized distance function', NULL, 'lazy'),
('LBR', 'Lazy Bayesian Rules classifier', NULL, 'lazy'),
('LeastMedianSquaredRegression', 'Robust regression using the median rather than the mean', NULL, 'functions'),
('LinearRegression', 'Standard linear regression', NULL, 'functions'),
('LocallyWeightedLearning', 'General algorithm for locally weighed learning', NULL, 'meta'),
('LogisticModelTree', 'Build logistic model trees', 'LMT builds logistic model trees. LMT can deal with binary and multiclass target variables, numeric and nominal attributes, and missing values. When fitting the logistic regression functions at a node, it uses cross-validation to determine how many iterations to run just once and employs the same number throughout the tree instead of cross-validating at every node. This heuristic (which you can switch off) improves the run time considerably, with little effect on accuracy. Alternatively, you can set the number of boosting iterations to be used throughout the tree. Normally, it is the misclassification error that cross-validation minimizes, but the root mean-squared error of the probabilities can be chosen instead. The splitting criterion can be based on C4.5''s information gain (default) or on the LogitBoost residuals, striving to improve the purity of the residuals.', 'trees'),
('LogisticRegression', 'Build linear logistic regression models', NULL, 'functions'),
('LogitBoost', 'Perform additive logistic regression', NULL, 'meta'),
('M5Prime', 'M5'' model tree learner', 'M5P builds a model tree, in which each leaf stores a linear regression model that predicts the class value of instances that reach the leaf.', 'trees'),
('M5Rules', 'Obtain rules from model trees built using M5''', NULL, 'rules'),
('MultiBoosting', 'Combine boosting and bagging using the MultiBoosting method', NULL, 'meta'),
('MultiClassWrapper', 'Use a two-class classifier for multiclass datasets', NULL, 'meta'),
('MultilayerPerceptron', 'Backpropagation Neural Network', NULL, 'functions'),
('NNge', 'Nearest-neighbor method of generating rules using nonnested generalized exemplars', NULL, 'rules'),
('NaiveBayes', 'Standard probabilistic Naive Bayes classifier', 'The probabilistic Naive Bayes classifier. It uses all attributes and allows them to make contributions to the decision that are equally important and independent of one another, given the class. It is based on Bayes'' rule to calculate conditional probability and ''naively'' assumes independence (it is only valid to multiply probabilities when the events are independent). The assumption that attributes are independent (given the class) is in real life certainly simplistic, but still Naive Bayes works very well when tested on actual datasets, particularly when combined with some sort of attribute selection that eliminates redundant, and hence nonindependent attributes. One thing that can go wrong with Naive Bayes is when a particular attribute value does not occur in the training set in conjunction with every class value (yielding zero probabilities, holding a veto over the other ones). \r\n\r\nThe implementation can use kernel density estimators to model numeric attributes, which improves performance if the normality assumption is grossly incorrect; it can also handle numeric attributes using supervised discretization.', 'bayes'),
('NaiveBayesTree', 'Build a decision tree with Naive Bayes classifiers at the leafs', 'NBTree is a hybrid between decision trees and Naive Bayes. It creates trees whose leaves are Naive Bayes classifiers for the instances that reach the leaf. When constructing the tree, cross-validation  is used to decide whether a node should be split further or a Naive Bayes model should be used instead (Kohavi 1996). ', 'trees'),
('OneR', '1R classifier', 'The 1R classifier generates a one-level decision tree expressed in the form of a set of rules that all test one particular attribute. 1R is a simple, cheap method that often comes up with quite good rules for characterizing the structure in data. It turns out that rather simple rules frequently achieve surprisingly high accuracy. Perhaps this is because the structure underlying many real-world datasets is quite rudimentary, and just one attribute is sufficient to determine the class of an instance quite accurately. ', 'rules'),
('OrdinalClassWrapper', 'Apply standard classification algorithms to problems with an ordinal class value', NULL, 'meta'),
('PART', 'Obtain rules from partial decision trees built using J4.8', NULL, 'rules'),
('PCANNSearch', NULL, NULL, 'search'),
('PLSNNSearch', NULL, NULL, 'search'),
('Prism', 'Simple covering algorithm for rules', NULL, 'rules'),
('RBFNetwork', 'Implements a radial basis function network', NULL, 'functions'),
('REPTree', 'Fast tree learner that uses reduced-error pruning', 'REPTree builds a decision or regression tree using information gain/variance reduction and prunes it using reduced-error pruning. Optimized for speed, it only sorts values for numeric attributes once. It deals with missing values by splitting instances into pieces (as C4.5 does).', 'trees'),
('RacedIncrementalLogitBoost', 'Batch-based incremental learning by racing logit-boosted committees', NULL, 'meta'),
('RandomCommittee', 'Build an ensemble of randomizable base classifiers', NULL, 'meta'),
('RandomForest', 'Construct random forests', 'Constructs random forests by bagging ensembles of random trees.', 'trees'),
('RandomTree', 'Construct a tree that considers a given number of random features at each node', 'Builds trees by choosing a test based on a given number of random features at each node, performing no pruning.', 'trees'),
('RegressionByDiscretizationWrapper', 'Discretize the class attribute and employ a classifier', NULL, 'meta'),
('RemovePercentage', NULL, NULL, 'DataPreprocessor'),
('Ripper', 'RIPPER algorithm for fast, effective rule induction', NULL, 'rules'),
('RippleDownRuleLearner', 'Ripple-down rule learner', NULL, 'rules'),
('SVM', 'Sequential minimal optimization algorithm for support vector classification', NULL, 'functions'),
('SVM-Regression', 'Sequential minimal optimization algorithm for support vector regression', NULL, 'functions'),
('SimpleLogisticRegression', 'Build linear logistic regression models with built-in attribute selection', NULL, 'functions'),
('SimpleNaiveBayes', 'Simple implementation of Naive Bayes', 'The probabilistic Naive Bayes classifier, uses a normal distribution to model numeric attributes (no kernel density estimators)', 'bayes'),
('Stacking', 'Combine several classifiers using the stacking method', NULL, 'meta'),
('StackingC', 'More efficient version of stacking', NULL, 'meta'),
('ThresholdSelectorWrapper', 'Optimize the F-measure for a probabilistic classifier', NULL, 'meta'),
('VoteWrapper', 'Combine classifiers using average of probability estimates or numeric predictions', NULL, 'meta'),
('VotedPerceptron', 'Voted perceptron algorithm', NULL, 'functions'),
('VotingFeatureIntervals', 'Voting feature intervals method, simple and fast', NULL, 'misc'),
('Winnow', 'Mistake-driven perceptron with multiplicative updates', NULL, 'functions'),
('ZeroRule', 'Predict the majority class (if nominal) or the average value (if numeric)', NULL, 'rules'),
('kNN', 'k-nearest neighbor classifier', NULL, 'lazy');