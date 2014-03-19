INSERT INTO `algorithm_setup` (`sid`, `parent`, `implementation_id`, `algorithm`, `role`, `isDefault`, `algorithm_structure`, `setup_string`) VALUES
(1, 0, 56, NULL, 'Learner', 'true', NULL, 'weka.classifiers.rules.ZeroR'),
(2, 0, 57, NULL, 'Learner', 'true', NULL, 'weka.classifiers.rules.OneR -- -B 6'),
(3, 0, 58, NULL, 'Learner', 'true', NULL, 'weka.classifiers.rules.Ridor -- -F 3 -S 1 -N 2.0'),
(4, 0, 59, NULL, 'Learner', 'true', NULL, 'weka.classifiers.lazy.IBk -- -K 1 -W 0 -A "weka.core.neighboursearch.LinearNNSearch -A \\"weka.core.EuclideanDistance -R first-last\\""'),
(5, 0, 60, NULL, 'Learner', 'true', NULL, 'weka.classifiers.bayes.NaiveBayes'),
(6, 0, 61, NULL, 'Learner', 'true', NULL, 'weka.classifiers.meta.AdaBoostM1 -- -P 100 -S 1 -I 10 -W weka.classifiers.trees.DecisionStump'),
(7, 0, 63, NULL, 'Learner', 'true', NULL, 'weka.classifiers.meta.Bagging -- -P 100 -S 1 -I 10 -W weka.classifiers.trees.REPTree -- -M 2 -V 0.001 -N 3 -S 1 -L -1'),
(8, 0, 65, NULL, 'Learner', 'true', NULL, 'weka.classifiers.trees.J48 -- -C 0.25 -M 2'),
(9, 0, 64, NULL, 'Learner', 'true', NULL, 'weka.classifiers.trees.REPTree -- -M 2 -V 0.001 -N 3 -S 1 -L -1'),
(10, 0, 62, NULL, 'Learner', 'true', NULL, 'weka.classifiers.trees.DecisionStump'),
(11, 0, 66, NULL, 'Learner', 'true', NULL, 'weka.classifiers.functions.SMO -- -C 1.0 -L 0.001 -P 1.0E-12 -N 0 -V -1 -W 1 -K "weka.classifiers.functions.supportVector.PolyKernel -C 250007 -E 1.0"'),
(12, 0, 68, NULL, 'Learner', 'true', NULL, 'weka.classifiers.functions.SMO -- -C 1.0 -L 0.001 -P 1.0E-12 -N 0 -V -1 -W 1 -K "weka.classifiers.functions.supportVector.RBFKernel -C 250007 -G 0.01"');