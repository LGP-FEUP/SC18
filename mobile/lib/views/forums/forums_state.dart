import 'package:flutter/material.dart';

class ForumsState extends ChangeNotifier {
  int selectedCategoryId = 0;

  void updateCategoryId(int selectedCategoryId) {
    this.selectedCategoryId = selectedCategoryId;
    notifyListeners();
  }
}
