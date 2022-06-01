import 'package:flutter/material.dart';

class CultureState extends ChangeNotifier {
  String selectedCategoryId = "";

  void updateCategoryId(String selectedCategoryId) {
    this.selectedCategoryId = selectedCategoryId;
    notifyListeners();
  }
}
